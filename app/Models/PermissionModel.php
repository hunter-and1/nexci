<?php namespace App\Models;

class PermissionModel extends \Myth\Auth\Authorization\PermissionModel
{
    
    /**
     * Gets all permissions for a user in a way that can be
     * easily used to check against:
     *
     * [
     *  id => name,
     *  id => name
     * ]
     *
     * @param int $userId
     *
     * @return array
     */
    public function getPermissionsForUserWithoutGroup(int $userId): array
    {
        return $this->db->table('auth_users_permissions')
        ->select('id, auth_permissions.name')
        ->join('auth_permissions', 'auth_permissions.id = permission_id', 'inner')
        ->where('user_id', $userId)
        ->get()
        ->getResultObject();
    }

        /**
     * Removes all permission from a user.
     *
     * @param int $permissionId
     * @param int $userId
     *
     * @return mixed
     */
    public function removeAllPermissionsFromUser(int $userId)
    {
        $this->db->table('auth_users_permissions')->where([
            'user_id' => $userId
        ])->delete();

        cache()->delete("{$userId}_permissions");
    }
}
