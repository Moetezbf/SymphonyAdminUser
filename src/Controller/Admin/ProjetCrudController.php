<?php

namespace App\Controller\Admin;

use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Projet;
use App\Message\RappelDeadline;
use App\Repository\ProjetRepository;
use Doctrine\Common\Collections\Expr\Value;
use Doctrine\DBAL\Types\IntegerType;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Faker\Provider\ar_EG\Text;
use Symfony\Component\DomCrawler\Field\FileFormField;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Messenger\MessageBusInterface;

class ProjetCrudController extends AbstractCrudController
{
    private $projetRepository;
    public function __construct(ProjetRepository $projetRepository)
    {
        $this->projetRepository = $projetRepository;
    }
    public static function getEntityFqcn(): string
    {
        return Projet::class;
    }


    public function configureFields(string $pageName): iterable
    {
        $fields = [
            TextField::new('Nom'),
            TextField::new('societe'),
            DateField::new('DatePub'),
            DateField::new('deadline'),
            ChoiceField::new('Avis')
                ->setChoices([
                    'Intéressant' => 'Intéressant',
                    'Non Intéressant' => 'Non Intéressant',
                ]),
            TextField::new('cahierDeCharge')
                ->setFormType(FileType::class),
            ChoiceField::new('suivi')
                ->setChoices([
                    'En attente' => 'en attente',
                    'En cours' => 'en cours',
                    'Terminé' => 'terminé',
                    'Abandonné' => 'abandonné',
                ]),
            TextField::new('OffreTechnique')
                ->setFormType(FileType::class),
            TextField::new('OffreAdministrative')
                ->setFormType(FileType::class),
            TextField::new('PartieFinanciere')
                ->setFormType(FileType::class),
            ChoiceField::new('Caution')
                ->setChoices([
                    'Oui' => 'Oui',
                    'Non' => 'Non',
                ]),
            TextField::new('montantCaution')
                ->setFormType(NumberType::class),
            ChoiceField::new('etatCaution')
                ->setChoices([
                    'Prêt' => 'pret',
                    'Non' => 'Non',
                ]),



            TextField::new('Motif')
        ];
        if ($pageName === 'edit') {
            $fields =
                [
                    ChoiceField::new('Avis')
                        ->setChoices([
                            'Intéressant' => 'Intéressant',
                            'Non Intéressant' => 'Non Intéressant',
                        ]),
                    TextField::new('cahierDeCharge')
                        ->setFormType(FileType::class),
                    ChoiceField::new('suivi')
                        ->setChoices([
                            'En attente' => 'en attente',
                            'En cours' => 'en cours',
                            'Terminé' => 'terminé',
                            'Abandonné' => 'abandonné',
                        ]),
                    TextField::new('OffreTechnique')
                        ->setFormType(FileType::class),
                    TextField::new('OffreAdministrative')
                        ->setFormType(FileType::class),
                    TextField::new('PartieFinanciere')
                        ->setFormType(FileType::class),
                    ChoiceField::new('Caution')
                        ->setChoices([
                            'Oui' => 'Oui',
                            'Non' => 'Non',
                        ]),
                    TextField::new('montantCaution')
                        ->setFormType(NumberType::class),
                    ChoiceField::new('etatCaution')
                        ->setChoices([
                            'Prêt' => 'pret',
                            'Non' => 'Non',
                        ]),

                    TextField::new('Motif')
                ];
        }

        return $fields;
    }
}
