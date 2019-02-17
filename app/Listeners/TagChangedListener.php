<?php

namespace App\Listeners;

use App\Events\TagCreatedOrUpdatedEvent;

class TagChangedListener
{
    // php artisan make:listener TagChangedListener
    // triggered from Tag::$dispatchEvents

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct() {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object $event
     * @return void
     */
    public function handle(TagCreatedOrUpdatedEvent $event) {
        //
        $event->tag->slug = str_slug($event->tag->name);
    }
}
