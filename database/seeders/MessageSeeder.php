<?php

namespace Database\Seeders;

use App\Models\Message;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MessageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ottieni tutti gli utenti che non sono clienti
        $users = User::whereDoesntHave('roles', function ($query) {
            $query->where('name', 'client');
        })->get();

        if ($users->count() < 2) {
            return; // Serve almeno 2 utenti per creare messaggi
        }

        $messages = [
            [
                'content' => 'Ciao! Come stai?',
                'created_at' => now()->subHours(2),
            ],
            [
                'content' => 'Tutto bene, grazie! E tu?',
                'created_at' => now()->subHours(1),
            ],
            [
                'content' => 'Perfetto! Hai visto il nuovo progetto?',
                'created_at' => now()->subMinutes(30),
            ],
            [
                'content' => 'Sì, sembra molto interessante!',
                'created_at' => now()->subMinutes(15),
            ],
            [
                'content' => 'Possiamo discuterne domani?',
                'created_at' => now()->subMinutes(5),
            ],
        ];

        // Crea messaggi tra i primi due utenti
        $user1 = $users->first();
        $user2 = $users->skip(1)->first();

        foreach ($messages as $index => $messageData) {
            $isFromUser1 = $index % 2 == 0;
            
            Message::create([
                'sender_id' => $isFromUser1 ? $user1->id : $user2->id,
                'receiver_id' => $isFromUser1 ? $user2->id : $user1->id,
                'content' => $messageData['content'],
                'is_read' => $index < 4, // Gli ultimi messaggi sono non letti
                'read_at' => $index < 4 ? now()->subMinutes(10) : null,
                'created_at' => $messageData['created_at'],
                'updated_at' => $messageData['created_at'],
            ]);
        }

        // Crea alcuni messaggi non letti per testare le notifiche
        if ($users->count() > 2) {
            $user3 = $users->skip(2)->first();
            
            Message::create([
                'sender_id' => $user3->id,
                'receiver_id' => $user1->id,
                'content' => 'Nuovo messaggio di test!',
                'is_read' => false,
                'created_at' => now()->subMinutes(2),
            ]);
        }
    }
}
