<?php

declare(strict_types=1);

/**
 * NOTICE OF LICENSE.
 *
 * UNIT3D Community Edition is open-sourced software licensed under the GNU Affero General Public License v3.0
 * The details is bundled with this project in the file LICENSE.txt.
 *
 * @project    UNIT3D Community Edition
 *
 * @author     HDVinnie <hdinnovations@protonmail.com>
 * @license    https://www.gnu.org/licenses/agpl-3.0.en.html/ GNU Affero General Public License v3.0
 */

namespace App\Notifications;

use App\Models\Gift;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class NewBon extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * NewBon Constructor.
     */
    public function __construct(public Gift $gift)
    {
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        $this->gift->load('sender');

        return [
            'title' => $this->gift->sender->username.' Has Gifted You '.$this->gift->bon.' BON',
            'body'  => $this->gift->sender->username.' has gifted you '.$this->gift->bon.' BON with the following note: '.$this->gift->message,
            'url'   => \sprintf('/users/%s', $this->gift->sender->username),
        ];
    }
}
