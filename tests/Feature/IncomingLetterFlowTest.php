<?php

use App\Models\IncomingLetter;
use App\Models\User;

function makeIncomingLetter(User $user, array $overrides = []): IncomingLetter
{
    return IncomingLetter::create(array_merge([
        'letter_number' => $overrides['letter_number'] ?? 'SM-' . uniqid(),
        'sender' => $overrides['sender'] ?? 'Unit Test',
        'subject' => $overrides['subject'] ?? 'Surat Test',
        'received_date' => $overrides['received_date'] ?? now()->toDateString(),
        'letter_date' => $overrides['letter_date'] ?? now()->toDateString(),
        'index_no' => $overrides['index_no'] ?? 1,
        'user_id' => $user->id,
        'forwarded_to' => $overrides['forwarded_to'] ?? null,
    ], $overrides));
}

test('sekretariat input creates letter with null forwarded_to', function () {
    $sekretariat = User::factory()->create(['role' => 'sekretariat']);

    $response = $this
        ->actingAs($sekretariat)
        ->post(route('surat-masuk.store'), [
            'letter_number' => 'SM-001',
            'sender' => 'Unit Test',
            'letter_date' => now()->toDateString(),
            'received_date' => now()->toDateString(),
            'subject' => 'Surat Uji',
            'index_no' => 1,
        ]);

    $response->assertRedirect(route('surat-masuk.index'));

    $this->assertDatabaseHas('incoming_letters', [
        'letter_number' => 'SM-001',
        'forwarded_to' => null,
        'user_id' => $sekretariat->id,
    ]);
});

test('sekretariat can add instruction', function () {
    $sekretariat = User::factory()->create(['role' => 'sekretariat']);
    $letter = makeIncomingLetter($sekretariat, [
        'letter_number' => 'SM-INS-1',
    ]);

    $response = $this
        ->actingAs($sekretariat)
        ->patch(route('surat-masuk.instruction', $letter), [
            'instruction' => 'Mohon tindak lanjut.',
        ]);

    $response->assertRedirect(route('detail-surat-masuk', $letter));

    $this->assertDatabaseHas('incoming_letters', [
        'id' => $letter->id,
        'instruction' => 'Mohon tindak lanjut.',
    ]);
});

test('admin can finalize incoming letter', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $sekretariat = User::factory()->create(['role' => 'sekretariat']);
    $letter = makeIncomingLetter($sekretariat, [
        'letter_number' => 'SM-KB-1',
    ]);

    $response = $this
        ->actingAs($admin)
        ->patch(route('surat-masuk.final-direction', $letter), [
            'final_direction' => 'Setujui dan arsipkan.',
        ]);

    $response->assertRedirect(route('detail-surat-masuk', $letter));

    $this->assertDatabaseHas('incoming_letters', [
        'id' => $letter->id,
        'final_direction' => 'Setujui dan arsipkan.',
    ]);
});

test('incoming letters index is scoped by role', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $sekretariatA = User::factory()->create(['role' => 'sekretariat']);
    $sekretariatB = User::factory()->create(['role' => 'sekretariat']);

    makeIncomingLetter($admin, ['letter_number' => 'ADM-1']);
    makeIncomingLetter($sekretariatA, ['letter_number' => 'SEC-1']);
    makeIncomingLetter($sekretariatB, ['letter_number' => 'SEC-2']);

    // Admin sees all letters
    $this->actingAs($admin)
        ->get(route('surat-masuk.index'))
        ->assertOk()
        ->assertSee('ADM-1')
        ->assertSee('SEC-1')
        ->assertSee('SEC-2');

    // Sekretariat sees letters from sekretariat and admin users
    $this->actingAs($sekretariatA)
        ->get(route('surat-masuk.index'))
        ->assertOk()
        ->assertSee('ADM-1')
        ->assertSee('SEC-1')
        ->assertSee('SEC-2');
});
