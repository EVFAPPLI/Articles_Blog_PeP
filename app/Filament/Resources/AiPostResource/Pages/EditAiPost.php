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
                ->label('Publier sur le Blog Public')
                ->icon('heroicon-o-rocket-launch')
                ->color('success')
                ->requiresConfirmation()
                ->modalHeading('Publier l\'article')
                ->modalDescription('Êtes-vous sûr de vouloir publier ce brouillon ? Un nouvel article officiel sera créé.')
                ->modalSubmitActionLabel('Oui, publier')
                ->visible(fn () => $this->record->status !== 'transferred')
                ->action(function () {
                    $record = $this->record;

                    // Vérifications de base
                    if (empty($record->title) || empty($record->html_content)) {
                        Notification::make()->warning()->title('Impossible de publier : Titre ou HTML manquant.')->send();
                        return;
                    }

                    // Création dans la vraie table posts
                    $post = Post::create([
                        'title' => $record->title,
                        'slug' => Str::slug($record->title) . '-' . time(),
                        'category' => $record->category ?? 'Non classé',
                        'html_content' => $record->html_content,
                        'vignette_content' => $record->vignette_content ?? '<p></p>',
                        'cover_image' => $record->cover_image,
                        'author' => 'Bruno Savoyat, PEP worldwide',
                        'is_published' => true,
                        'published_at' => now(),
                    ]);

                    // Mise a jour du statut du brouillon et sauvegarde de l'ID post
                    $record->update(['status' => 'transferred', 'post_id' => $post->id]);

                    Notification::make()->success()->title('Brouillon publié avec succès sur le blog public !')->send();
                }),
        ];
    }

    protected function afterSave(): void
    {
        $record = $this->record;

        // Si l'article est déjà lié à un article public, on le met à jour automatiquement à chaque sauvegarde du brouillon
        if ($record->status === 'transferred' && $record->post_id) {
            $post = Post::find($record->post_id);
            if ($post) {
                $post->update([
                    'title' => $record->title,
                    'category' => $record->category ?? 'Non classé',
                    'html_content' => $record->html_content,
                    'vignette_content' => $record->vignette_content ?? '<p></p>',
                    'cover_image' => $record->cover_image,
                ]);
                Notification::make()->success()->title('Article public synchronisé automatiquement !')->send();
            }
        }
    }
}
