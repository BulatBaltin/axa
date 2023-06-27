<?

class User extends dmModel {

    static function post($id) {
        return self::belongsTo( $id, 'posts');
    }
    static function Registered() {
        return false;
    }
    
    static function GetUser($id = null) {
        if($id) {
            $user = User::find($id);
            return $user;
        } else {
            $session    = new DataLinkSession();
            $user       = $session->get('boss_user');
            if($user) { // 
                // $user = User::find($user['id']);
                return $user;
            }
        }
        return false;
        // if(!$id) $id = 2; // Maije
    }
    static function GetHash($id = null) {
        $user = User::GetUser($id);
        return $user['hash'] ?? '#guest#';
    }
    static function GetCompany($user) {
        return Company::find($user['company_id']);
    }
    static function Name($id) {
        
        $record = User::find($id);
        if(!$record) return "Unknown author"; 
        return $record['name'];
    }

    static function __GetFieldsEmloyees()
    {
        // List headers
        return
            [
                // ['label' => ll('Surname'),  'name' => 'sirname'],
                ['label' => ll('Name'),  'name' => 'name'],
                ['label' => ll('Role'),  'name' => 'role'],
                // ['label' => 'Activated', 'name' => 'status'],
            ];
    }

    static function isTrackable($user): bool
    {
        return self::hasRole($user,'ROLE_ADMIN') or 
               self::hasRole($user,'ROLE_DEVELOPER') or
               self::hasRole($user,'ROLE_USER');
    }
    static function hasRole($user, $value): ?bool
    {
        return strpos($user['role'], $value) !== false;
    }

    static function getRoles(array $user): array
    {
        $roles = !empty($user['role']) ? explode(';',$user['role']) : ['ROLE_USER'];
        return array_unique($roles);
    }
    static function addRole(array &$user, string $role): array
    {
        $roles = self::getRoles($user);
        $roles[] = strtoupper($role);
        $roles = array_unique($roles);
        $user['role'] = implode(';', $roles);

        return self::getRoles($user);
    }
    static function setRoles(array &$user, array $roles)
    {
        $all_roles = self::getRoleName(); //$user);
        $new_roles = [];
        foreach ($roles as $role) {
            if (array_key_exists($role, $all_roles)) {
                $new_roles[] = $role;
            }
        }

        $roles = array_unique($new_roles);
        $user['role'] = implode(';', $roles);
        return $user['role'];
    }
    static function getRoleName($role = null)
    {
        $all_roles = [
            "ROLE_USER" => 'Application User',
            "ROLE_ACCOUNTANT" => 'Accountant / Sales Man',
            "ROLE_DEVELOPER" => 'Programmer',
            "ROLE_CUSTOMER" => 'Customer',
            "ROLE_ADMIN" => 'Company Admin',
            "ROLE_SUPER_ADMIN" => 'Super Admin'
        ];
        if ($role) return $all_roles[$role];
        return $all_roles;
    }
    static function map_roles(array $roles): array
    {
        $role_names = self::getRoleName();
        $new_roles = array();
        $i = 0;
        foreach ($roles as $role) {
            if (array_key_exists($role, $role_names)) {
                $new_roles[] = ['position' => ++$i, 'role' => $role, 'name' => $role_names[$role]];
            }
        }
        if (count($new_roles) === 0) {
            $role = "ROLE_USER";
            $new_roles[] = ['position' => 1, 'role' => $role, 'name' => $role_names[$role]];
        }
        return $new_roles;
    }

    static function encodePassword(string $raw): string
    {
        return password_hash($raw, PASSWORD_DEFAULT);
    }
    static function verifyPassword(string $raw, string $encoded): bool
    {
        return password_verify($raw, $encoded);
    }
    static function Lingo($lang = 'en'): string {
        return 'en';
    }
}