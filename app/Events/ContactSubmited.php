<?php

namespace App\Events;

use App\Models\Contact;

class ContactSubmited extends Event
{
    private $data;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Contact $contact)
    {
        $this->data = $contact;
    }
}
