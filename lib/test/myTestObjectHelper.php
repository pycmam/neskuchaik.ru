<?php

/**
 * Хелпер для создания объектов моделей
 */
class myTestObjectHelper extends sfPHPUnitObjectHelper
{
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
