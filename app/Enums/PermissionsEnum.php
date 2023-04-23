<?php
namespace App\Enums;

enum PermissionsEnum: string
{
    // case NAMEINAPP = 'name-in-database';

    case createOrganization = 'create_organization';
    case listOrganizations = 'list_organizations';
    case editOrganization = 'edit_organization';
    case deleteOrganization = 'delete_organization';
    case blockOrganization = 'block_organization';

    case createAdmin = 'create_admin';
    case listAdmins = 'list_admins';
    case editAdmin = 'edit_admin';
    case deleteAdmin = 'delete_admin';
    case blockAdmin = 'block_admin';

    case createProvider = 'create_provider';
    case listProvider = 'list_providers';
    case editProvider = 'edit_provider';
    case deleteProvider = 'delete_provider';

    case createLevel = 'create_level';
    case listLevel = 'list_levels';
    case editLevel = 'edit_level';
    case deleteLevel = 'delete_level';

    case createCategory = 'create_category';
    case listCategory = 'list_categories';
    case editCategory = 'edit_category';
    case deleteCategory = 'delete_category';

    case createCourse = 'create_course';
    case listCourse = 'list_courses';
    case editCourse = 'edit_course';
    case deleteCourse = 'delete_course';

    case createRole = 'create_role';
    case editRole = 'edit_role';
    case listRoles = 'list_roles';

    case listPermissions = 'list_permissions';



    // extra helper to allow for greater customization of displayed values, without disclosing the name/value data directly
    public static function label(): string
    {
        return match ($this) {
            static::createOrganization => 'Create Organization',
            static::listOrganizations => 'List Organizations',
            static::editOrganization => 'Edit Organization',
            static::deleteOrganization => 'Delete Organization',
            static::blockOrganization => 'Block Organization',

        };
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function forSelect(): array
    {
        return array_combine(
            array_column(self::cases(), 'value'),
            array_column(self::cases(), 'name')
        );
    }
}
