<?php

namespace App\Repositories;

use App\Models\Contact;

class ContactRepository
{
    public function store(array $data): Contact
    {
        $contact = new Contact;

        return $this->valuable($contact, $data);
    }

    public function valuable(Contact $contact, array $param = []): Contact
    {
        $param = (object) $param;

        !isset($param->name) ?: $contact->name = $param->name;
        !isset($param->email) ?: $contact->email = $param->email;
        !isset($param->telephone) ?: $contact->telephone = $param->telephone;
        !isset($param->subject) ?: $contact->subject = $param->subject;
        !isset($param->message) ?: $contact->message = $param->message;

        $contact->save();

        return $contact;
    }
}
