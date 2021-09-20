<?php

namespace App\Controller\Admin;

use App\Entity\ContactRequest;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ContactRequestCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return ContactRequest::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('contactUser.lastname', 'Nom'),
            TextField::new('contactUser.email', 'Email'),
            DateField::new('createDate', 'Date de création'),
            TextField::new('request', 'Message'),
            BooleanField::new('isOpen', 'Ouverte'),
        ];
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setDefaultSort(['contactUser.email' => 'DESC', 'createDate' => 'DESC']);
    }
}
