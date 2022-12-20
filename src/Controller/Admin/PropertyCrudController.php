<?php

namespace App\Controller\Admin;

use App\Entity\Property;
use App\Form\ImageType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class PropertyCrudController extends AbstractCrudController
{

    public static function getEntityFqcn(): string
    {
        return Property::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Bien')
            ->setEntityLabelInPlural('Biens')
            ->setSearchFields(['title', 'city', 'zip_code', 'price', 'reference', 'type', 'surface', 'category.name']);
    }

    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('title', label: 'Titre')
            ->setColumns(6);
        yield TextEditorField::new('description', label: 'Description')
            ->setColumns(6);
        yield TextField::new('city', label: 'Ville')
            ->setColumns(6);
        yield IntegerField::new('zip_code', label: 'Code Postal')
            ->setColumns(6);
        yield TextField::new('reference', label: 'Référence')
            ->setColumns(6);
        yield ChoiceField::new('type', label: 'Type')
            ->setChoices(['Location' => 'Location', 'Vente' => 'Vente'])
            ->setColumns(6);
        yield IntegerField::new('surface', label: 'Surface')
            ->setColumns(6);
        yield AssociationField::new('category', label: 'Catégorie')
            ->setColumns(6);
        yield MoneyField::new('price', label: 'Prix')
            ->setCurrency('EUR')
            ->setColumns(6);

        yield AssociationField::new('images', label: 'Photos')->onlyOnIndex();
        yield CollectionField::new('images', label: 'Photos')
            ->setEntryType(ImageType::class)
            ->setColumns(6)
            ->onlyOnForms();
        yield CollectionField::new('images', label: 'Photos')
            ->setFormTypeOption('propertyFile', 'imageFile')
            ->setTemplatePath('admin/snippets/images.html.twig')
            ->onlyOnDetail();

    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add('index', 'detail');
    }

}
