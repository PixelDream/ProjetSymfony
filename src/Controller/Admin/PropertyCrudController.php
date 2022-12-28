<?php

namespace App\Controller\Admin;

use App\Controller\Admin\Fields\AutoCompleteField;
use App\Entity\Property;
use App\Form\ImageType;
use App\Message\SendPropertyEmailMessage;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Messenger\MessageBusInterface;

class PropertyCrudController extends AbstractCrudController
{
    private MessageBusInterface $messageBus;

    public function __construct(MessageBusInterface $messageBus)
    {
        $this->messageBus = $messageBus;
    }

    public static function getEntityFqcn(): string
    {
        return Property::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Bien')
            ->setEntityLabelInPlural('Biens')
            ->setSearchFields(['title', 'city', 'zipCode', 'price', 'reference', 'type', 'surface', 'category.name']);
    }

    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('title', label: 'Titre')
            ->setColumns(6);
        yield TextEditorField::new('description', label: 'Description')
            ->setColumns(6);
        yield TextField::new('city', label: 'Ville')
            ->setColumns(6);
        yield IntegerField::new('zipCode', label: 'Code Postal')
            ->addCssClass("cityInput")
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
            ->setTemplatePath('admin/fields/images.html.twig')
            ->onlyOnDetail();
//        yield ChoiceField::new('city', 'Ville')
//            ->setVirtual(true)
//            ->hideOnIndex()
//            ->setCssClass('field-auto-complete')
//            ->setFormTypeOptions([
//                'row_attr' => [
//                    'data-controller' => 'city',
//                ],
//                'attr' => [
//                    'data-snarkdown-target' => 'input',
//                    'data-action' => 'snarkdown#render',
//                ],
//            ])
//            ->setTemplatePath('admin/fields/city.html.twig');


    }

    // create new message with sendPropertyEmailMessage when a property is created
    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        // if created date is null, it's a new property else it's an update
        if ($entityInstance->getCreatedAt() === null) {
            parent::persistEntity($entityManager, $entityInstance);

            $message = new SendPropertyEmailMessage($entityInstance);
            $this->messageBus->dispatch($message);
        } else {
            parent::persistEntity($entityManager, $entityInstance);
        }
    }


    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add('index', 'detail');
    }

}
