<?php

/**
 * Хелпер для создания объектов моделей
 */
class myTestObjectHelper extends sfPHPUnitObjectHelper
{
    /**
     * Создать sfGuardUser
     */
    public function makeUser($save = false, array $props = array())
    {
        $defaultProps = array(
            'username' => 'username-' . $this->getUniqueCounter(),
            'email_address' => $this->makeEmail(),
            'first_name' => $this->makeText('first name'),
            'last_name' => $this->makeText('last name'),
            'password' => 1,
        );
        $props = array_merge($defaultProps, $props);

        return $this->makeModel('sfGuardUser', $props, $save);
    }

    /**
     * Создать sfGuardGroup
     */
    public function makeGuardGroup($save = false, array $props = array())
    {
        $defaultProps = array(
            'name' => $this->makeText('Group name'),
            'description' => $this->makeText('Group description'),
        );
        $props = array_merge($defaultProps, $props);

        return $this->makeModel('sfGuardGroup', $props, $save);
    }

    /**
     * Создать sfGuardPermission
     */
    public function makeGuardPermission($save = false, array $props = array())
    {
        $defaultProps = array(
            'name' => $this->makeText('Permission name'),
            'description' => $this->makeText('Permission description'),
        );
        $props = array_merge($defaultProps, $props);

        return $this->makeModel('sfGuardPermission', $props, $save);
    }

    /**
     * Создать sfGuardUserGroup
     */
    public function makeGuardUserGroup(sfGuardUser $user, sfGuardGroup $group, $save = false, array $props = array())
    {
        $defaultProps = array(
            'user_id' => $user->getId(),
            'group_id' => $group->getId(),
        );
        $props = array_merge($defaultProps, $props);

        return $this->makeModel('sfGuardUserGroup', $props, $save);
    }

    /**
     * Создать sfGuardGroupPermission
     */
    public function makeGuardGroupPermission(sfGuardGroup $group, sfGuardPermission $permission, $save = false, array $props = array())
    {
        $defaultProps = array(
            'group_id' => $group->getId(),
            'permission_id' => $permission->getId(),
        );
        $props = array_merge($defaultProps, $props);

        return $this->makeModel('sfGuardGroupPermission', $props, $save);
    }

    /**
     * Создать sfGuardUserPermission
     */
    public function makeGuardUserPermission(sfGuardUser $user, sfGuardPermission $permission, $save = false, array $props = array())
    {
        $defaultProps = array(
            'user_id' => $user->getId(),
            'permission_id' => $permission->getId(),
        );
        $props = array_merge($defaultProps, $props);

        return $this->makeModel('sfGuardUserPermission', $props, $save);
    }

    /**
     * Создать Place
     */
    public function makePlace(sfGuardUser $user, $save = false, array $props = array())
    {
        $defaultProps = array(
            'user_id' => $user->getId(),
            'title' => $this->makeText('title', false),
            'description' => $this->makeText('description', false),
            'icon' => 'star',
        );
        $props = array_merge($defaultProps, $props);

        return $this->makeModel('Place', $props, $save);
    }

    /**
     * Создать Event
     */
    public function makeEvent(sfGuardUser $user, $save = false, array $props = array())
    {
        $defaultProps = array(
            'user_id' => $user->getId(),
            'title' => $this->makeText('title', false),
            'description' => $this->makeText('description', false),
            'fire_at' => date('Y-m-d H:i:s', strtotime('+1 day')),
            'icon' => 'star',
        );
        $props = array_merge($defaultProps, $props);

        return $this->makeModel('Event', $props, $save);
    }

    /**
     * Создать Comment
     */
    public function makeComment(Point $point, sfGuardUser $user, $save = false, array $props = array())
    {
        $defaultProps = array(
            'user_id' => $user->id,
            'point_id' => $point->id,
            'comment' => $this->makeText('comment', false),
        );
        $props = array_merge($defaultProps, $props);

        return $this->makeModel('Comment', $props, $save);
    }

    /**
     * Создать PointUser
     */
    public function makePointUser(Point $point, sfGuardUser $user, $save = false, array $props = array())
    {
        $defaultProps = array(
            'user_id' => $user->getId(),
            'point_id' => $point->getId(),
        );
        $props = array_merge($defaultProps, $props);

        return $this->makeModel('PointUser', $props, $save);
    }

    /**
     * Создать Identity
     */
    public function makeIdentity(sfGuardUser $user, $save = false, array $props = array())
    {
        $defaultProps = array(
            'user_id' => $user->getId(),
            'identity' => $this->makeText('identity'),
            'provider' => $this->makeText('provider'),
        );
        $props = array_merge($defaultProps, $props);

        return $this->makeModel('Identity', $props, $save);
    }



    /**
     * Создать email
     *
     * @param  string $text - дополнительный текст
     * @return string
     */
    public function makeEmail($text = null)
    {
        if (!$text) {
            $text = 'email';
        } else {
            $text .= '-email';
        }

        return sprintf('%s-%d@example.org', $text, $this->getUniqueCounter());
    }
}
