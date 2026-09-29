<?php

namespace Tests\Feature;

use App\Models\User;
use App\UserRole;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Menguji alur autentikasi admin dan pembeli.
 */
class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Halaman utama langsung menampilkan halaman login tanpa halaman pendarat.
     */
    public function test_halaman_utama_mengarah_ke_halaman_login(): void
    {
        $this->get('/')->assertRedirect('/login');

        $this->get('/login')
            ->assertOk()
            ->assertSee('Masuk ke Akun');
    }

    /**
     * Admin yang berhasil masuk diarahkan ke dasbor admin.
     */
    public function test_admin_diarahkan_ke_dasbor_admin(): void
    {
        $admin = User::factory()->admin()->create(['password' => 'rahasia123']);

        $respons = $this->post('/login', [
            'email' => $admin->email,
            'password' => 'rahasia123',
        ]);

        $this->assertAuthenticatedAs($admin);
        $respons->assertRedirect(route('admin.dashboard'));
    }

    /**
     * Pembeli yang berhasil masuk langsung diarahkan ke halaman belanja.
     */
    public function test_pembeli_diarahkan_ke_halaman_katalog(): void
    {
        $pembeli = User::factory()->create(['password' => 'rahasia123']);

        $respons = $this->post('/login', [
            'email' => $pembeli->email,
            'password' => 'rahasia123',
        ]);

        $this->assertAuthenticatedAs($pembeli);
        $respons->assertRedirect(route('dashboard'));
    }

    /**
     * Data masuk yang salah menampilkan pesan kesalahan pada kolom email.
     */
    public function test_kredensial_salah_menampilkan_pesan_kesalahan(): void
    {
        $pembeli = User::factory()->create(['password' => 'rahasia123']);

        $respons = $this->from('/login')->post('/login', [
            'email' => $pembeli->email,
            'password' => 'kata-sandi-salah',
        ]);

        $respons->assertRedirect('/login');
        $respons->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    /**
     * Pendaftaran membuat akun baru dengan peran pembeli.
     */
    public function test_pendaftaran_membuat_akun_pembeli_baru(): void
    {
        $respons = $this->post('/register', [
            'name' => 'Pembeli Baru',
            'email' => 'pembeli.baru@bookstore.test',
            'phone' => '081200001111',
            'password' => 'rahasia123',
            'password_confirmation' => 'rahasia123',
        ]);

        $respons->assertRedirect(route('dashboard'));

        $this->assertDatabaseHas('users', [
            'email' => 'pembeli.baru@bookstore.test',
            'role' => UserRole::User->value,
        ]);

        $this->assertAuthenticated();
    }
}
