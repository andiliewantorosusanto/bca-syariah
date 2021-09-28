<?php

namespace App\Traits;

use App\Models\Permission;
trait hasPermissionsTrait
{
    /**
     * @param $permission
     * @return bool
     */
    public function hasPermissionTo($permission)
    {
        $permission = Permission::where('slug',$permission)->first();

        if($permission !== null) {
            foreach($this->permissions as $userPermission) {
                if($permission->id === $userPermission->id) {
                    return true;
                }
            }
        }

        return false;
    }
}

?>