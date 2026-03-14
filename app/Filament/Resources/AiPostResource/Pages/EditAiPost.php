<?php

namespace App\Filament\Resources\AiPostResource\Pages;

use App\Filament\Resources\AiPostResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Notifications\Notification;
use App\Models\Post;
use Illuminate\Support\Str;

class EditAiPost extends EditRecord
{
    protected static string $resource = AiPostResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\Action::make('transfer_to_blog')
                ->label('Transférer sur le Blog Public')
                ->icon('heroicon-o-rocket-launch')
                ->color('success')
                ->requiresConfirmation()
                ->modalHeading('Publier l\'article')
                ->modalDescription('Êtes-vous sûr de vouloir transférer ce brouillon vers le blog public ? Un nouvel article officiel sera créé.')
                ->modalSubmitActionLabel('Oui, publier')
                ->visible(fn () => $this->record->status !== 'transferred')
                ->action(function () {
                    $record = $this->record;

                    // Vérifications de base
                    if (empty($record->title) || empty($record->html_content)) {
                        Notification::make()->warning()->title('Impossible de transférer : Titre ou HTML manquant.')->send();
                        return;
                    }

                    // Création dans la vraie table posts
                    $post = Post::create([
                        'title' => $record->title,
                        'slug' => Str::slug($record->title) . '-' . time(), // ajout time() pour éviter conflit de slug 
                        'category' => $record->category ?? 'Non classé',
                        'html_content' => $record->html_content,
                        'vignette_content' => $record->vignette_content ?? '<p></p>',
                        'cover_image' => $record->cover_image,
                        'author' => 'Bruno Savoyat, PEP worldwide',
                        'is_published' => true,
                        'published_at' => now(),
                    ]);

                    // Mise a jour du statut du brouillon
                    $record->update(['status' => 'transferred']);

                    Notification::make()->success()->title('Brouillon transféré avec succès sur le blog public !')->send();
                }),
        ];
    }
}
