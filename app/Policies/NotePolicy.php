<?php

namespace App\Policies;

use App\Note;
use App\Role;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class NotePolicy
{
    use HandlesAuthorization;

    /**
     * @param User $user
     * @param $ability
     * @return bool
     */
    public function before(User $user, $ability)
    {
        if ($user->isAdmin())
            return true;
    }

    /**
     * Determine whether the user can view all notes.
     *
     * @param  \App\User $user
     * @return boolean
     */
    public function index(User $user)
    {
        return $user->isAuthorized('notes', Role::UT_READ);
    }

    /**
     * Determine whether the user can view the note.
     *
     * @param  \App\User $user
     * @param Note $note
     * @return boolean
     */
    public function view(User $user, Note $note)
    {
        if ($note->private)
            return $user->id == $note->user_id ?? false;
        else
            return $user->isAuthorized('notes', Role::UT_READ);
    }

    /**
     * Determine whether the user can create notes.
     *
     * @param  \App\User $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->isAuthorized('notes', Role::UT_CREATE);
    }

    /**
     * Determine whether the user can update the note.
     *
     * @param  \App\User $user
     * @param Note $note
     * @return mixed
     */
    public function update(User $user, Note $note)
    {
        return $user->isAuthorized('notes', Role::UT_UPDATE) && $note->user_id == $user->id;
    }

    /**
     * Determine whether the user can delete the note.
     *
     * @param  \App\User $user
     * @param Note $note
     * @return mixed
     */
    public function delete(User $user, Note $note)
    {
        return $user->isAuthorized(' notes', Role::UT_DELETE) && $note->user_id == $user->id;
    }
}
