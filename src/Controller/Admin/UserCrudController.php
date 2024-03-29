<?php

namespace App\Controller\Admin;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TelephoneField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

/**
 * CRUD d'administration pour les utilisateurs
 * Class UserCrudController
 * @package App\Controller\Admin
 */
class UserCrudController extends AbstractCrudController
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Utilisateur')
            ->setEntityLabelInPlural('Utilisateurs')
            ->setSearchFields(['email', 'firstName', 'lastName']);

    }

    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id')->hideOnForm();
        yield TextField::new('firstName', label: 'Prénom')->setColumns(6);
        yield TextField::new('lastName', label: 'Nom')->setColumns(6);
        yield TelephoneField::new('phone', label: 'Téléphone')->setColumns(6);
        yield EmailField::new('email', label: 'Email')->setColumns(6);
        yield TextField::new('password', label: 'Mot de passe')->setColumns(6)->setFormType(PasswordType::class)->hideOnIndex()->setEmptyData("")->setValue("")->setRequired(false);
        yield ChoiceField::new('roles', label: 'Roles')->allowMultipleChoices()->setChoices(static fn(?User $user): array => $user->getRolesChoices())->setColumns(6);
        yield BooleanField::new('isVerified', label: 'Email valide')->setColumns(6)->hideOnIndex();
    }

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        if ($entityInstance instanceof User && $entityInstance->getPassword() !== "") {
            $entityInstance->setPassword($this->passwordHasher->hashPassword($entityInstance, $entityInstance->getPassword()));

            parent::persistEntity($entityManager, $entityInstance);
        }

    }

}
