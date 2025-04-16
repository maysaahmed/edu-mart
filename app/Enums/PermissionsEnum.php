<?php
namespace App\Enums;

enum PermissionsEnum: string
{

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
    case listProviders = 'list_providers';
    case editProvider = 'edit_provider';
    case deleteProvider = 'delete_provider';

    case createLevel = 'create_level';
    case listLevels = 'list_levels';
    case editLevel = 'edit_level';
    case deleteLevel = 'delete_level';

    case createCategory = 'create_category';
    case listCategories = 'list_categories';
    case editCategory = 'edit_category';
    case deleteCategory = 'delete_category';

    case createCourse = 'create_course';
    case listCourses = 'list_courses';
    case editCourse = 'edit_course';
    case deleteCourse = 'delete_course';

    case createRole = 'create_role';
    case editRole = 'edit_role';
    case listRoles = 'list_roles';

    case listPermissions = 'list_permissions';


    case createUser = 'create_user';
    case listUsers = 'list_users';
    case editUser = 'edit_user';
    case deleteUser = 'delete_user';
    case blockUser = 'block_user';

    case listManagers = 'list_managers';
    case createManager = 'create_manager';
    case editManager = 'edit_manager';
    case deleteManager = 'delete_manager';
    case blockManager = 'block_manager';

    case listRequests = 'list_requests';
    case editRequests = 'edit_requests';

    //assessment permissions
    case listQuestions = 'list_questions';
    case editQuestions = 'edit_questions';
    case editFactors = 'edit_Factors';


    //technical assessments permissions
    case listAssessments = 'list_assessments';
    case createAssessment = 'create_assessment';
    case editAssessment = 'edit_assessment';
    case deleteAssessment = 'delete_assessment';

    case createAssessmentQuestion = 'create_assessment_question';
    case editAssessmentQuestion = 'edit_assessment_question';
    case deleteAssessmentQuestion = 'delete_assessment_question';

    case createAssessmentTier = 'create_assessment_tier';
    case editAssessmentTier = 'edit_assessment_tier';
    case deleteAssessmentTier = 'delete_assessment_tier';

    case assignAssessmentOrganization = 'assign_assessment_organization';




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
