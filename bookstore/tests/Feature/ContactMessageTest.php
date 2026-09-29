<?php

namespace Tests\Feature;

use App\Models\ContactMessage;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Menguji fitur pesan pengguna kepada admin.
 */
class ContactMessageTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Pembeli dapat mengirim pesan kepada admin melalui halaman kontak.
     */
    public function test_pembeli_dapat_mengirim_pesan_ke_admin(): void
    {
        $pembeli = User::factory()->create();

        $respons = $this->actingAs($pembeli)->post(route('store.pages.contact.store'), [
            'sender_name' => 'Budi Pembeli',
            'sender_email' => 'budi@bookstore.test',
            'subject' => 'Pertanyaan Pengiriman',
            'message' => 'Apakah pengiriman ke luar kota tersedia?',
        ]);

        $respons->assertRedirect(route('store.pages.contact'));
        $respons->assertSessionHas('success');

        $this->assertDatabaseHas('contact_messages', [
            'user_id' => $pembeli->id,
            'subject' => 'Pertanyaan Pengiriman',
            'is_read' => 0,
        ]);
    }

    /**
     * Pesan wajib diisi dengan data yang lengkap.
     */
    public function test_pesan_tanpa_subjek_menghasilkan_kesalahan_validasi(): void
    {
        $respons = $this->actingAs(User::factory()->create())
            ->post(route('store.pages.contact.store'), [
                'sender_name' => 'Budi Pembeli',
                'sender_email' => 'budi@bookstore.test',
                'subject' => '',
                'message' => 'Isi pesan.',
            ]);

        $respons->assertSessionHasErrors('subject');
    }

    /**
     * Admin dapat membaca pesan dan statusnya berubah menjadi sudah dibaca.
     */
    public function test_admin_membaca_pesan_dan_menandainya_sudah_dibaca(): void
    {
        $pesan = ContactMessage::factory()->create(['subject' => 'Pesan Uji Admin']);

        $respons = $this->actingAs(User::factory()->admin()->create())
            ->get(route('admin.messages.show', $pesan));

        $respons->assertOk();
        $respons->assertSee('Pesan Uji Admin');
        $this->assertTrue($pesan->fresh()->is_read);
    }
}
