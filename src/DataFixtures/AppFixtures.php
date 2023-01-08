<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Image;
use App\Entity\Property;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    /**
     * Génération des fixtures pour les tests et environnement de dev
     * @inheritDoc
     */
    public function load(ObjectManager $manager): void
    {
        $dataSet = [
            [
                "Reference" => "38TB22187",
                "Intitule" => "Vallons du Voironnais",
                "Descriptif" => "13 Ha de terrain",
                "Localisation" => 38500,
                "City" => "Voiron",
                "Surface" => 130000,
                "Prix" => 2000,
                "Type" => "Location",
                "Categorie" => "Terrain agricole"
            ],
            [
                "Reference" => "48RE11201",
                "Intitule" => "Situé à 15 minutes de Mende",
                "Descriptif" => "idéal pour polyculture sur 14 ha",
                "Localisation" => 30430,
                "City" => "Saint-Privat",
                "Surface" => 100000,
                "Prix" => 1300,
                "Type" => "Location",
                "Categorie" => "Terrain agricole"
            ],
            [
                "Reference" => "47.06.098",
                "Intitule" => "PRET A USAGE sur 95 ha - PLAINE DES VOSGES",
                "Descriptif" => "A 5 min de Villeneuve-sur-Lot",
                "Localisation" => 47300,
                "City" => "Villeneuve-sur-Lot",
                "Surface" => 140000,
                "Prix" => 11000,
                "Type" => "Location",
                "Categorie" => "Terrain agricole"
            ],
            [
                "Reference" => "88 FB",
                "Intitule" => "Vittel Dombrot : Ouest vosgien, secteur de VITTEL",
                "Descriptif" => "Terrains d'environ 6,5 ha",
                "Localisation" => 88170,
                "City" => "Vittel",
                "Surface" => 65000,
                "Prix" => "Nous consulter",
                "Type" => "Vente",
                "Categorie" => "Terrain agricole"
            ],
            [
                "Reference" => "5667DB",
                "Intitule" => "Ancienne ferme équestre en ruine",
                "Descriptif" => "Terrains actuellement loués",
                "Localisation" => 29510,
                "City" => "Plougasnou",
                "Surface" => 120000,
                "Prix" => 156000,
                "Type" => "Vente",
                "Categorie" => "Terrain agricole"
            ],
            [
                "Reference" => "765DN",
                "Intitule" => "Prairies orientées nord ouest",
                "Descriptif" => "Lot d'un seul tenant",
                "Localisation" => 56500,
                "City" => "Ploeren",
                "Surface" => 110000,
                "Prix" => 113000,
                "Type" => "Vente",
                "Categorie" => "Prairie"
            ],
            [
                "Reference" => "76RZDC",
                "Intitule" => "Terrain proche cours d'eau",
                "Descriptif" => "Non accessible par la route, uniquement chemin d'exploitation",
                "Localisation" => 35200,
                "City" => "Rennes",
                "Surface" => 55000,
                "Prix" => 3000,
                "Type" => "Location",
                "Categorie" => "Prairie"
            ],
            [
                "Reference" => "9875RDC",
                "Intitule" => "Terrain avec abri",
                "Descriptif" => "Pour propriétaire équin",
                "Localisation" => 44110,
                "City" => "Chateaubriant",
                "Surface" => 12000,
                "Prix" => 1200,
                "Type" => "Location",
                "Categorie" => "Prairie"
            ],
            [
                "Reference" => "Z34.345.45",
                "Intitule" => "Légèrement en Pente",
                "Descriptif" => "Idéal paturage moutons",
                "Localisation" => 22700,
                "City" => "Paimpol",
                "Surface" => 34000,
                "Prix" => 2400,
                "Type" => "Location",
                "Categorie" => "Prairie"
            ],
            [
                "Reference" => "64.02.59",
                "Intitule" => "Productions végétales",
                "Descriptif" => "La parcelle se situe dans le Béarn sur la commune de LAGOR.",
                "Localisation" => 64150,
                "City" => "Lagor",
                "Surface" => 20000,
                "Prix" => 7700,
                "Type" => "Vente",
                "Categorie" => "Prairie"
            ],
            [
                "Reference" => "7629CA",
                "Intitule" => "Prairies sur les plateaux",
                "Descriptif" => "Parcelle de terre labourable d'environ 2 ha",
                "Localisation" => 81090,
                "City" => "Cahuzac-sur-Vère",
                "Surface" => 760000,
                "Prix" => 400000,
                "Type" => "Vente",
                "Categorie" => "Prairie"
            ],
            [
                "Reference" => "43LM220118",
                "Intitule" => "Prairies en pays glazik",
                "Descriptif" => "Usage petits animaux type caprins",
                "Localisation" => 29510,
                "City" => "Plougasnou",
                "Surface" => 12200,
                "Prix" => 15000,
                "Type" => "Vente",
                "Categorie" => "Prairie"
            ],
            [
                "Reference" => "65.23.876",
                "Intitule" => "Terrain classé T4",
                "Descriptif" => "cloturé et partiellement boisé",
                "Localisation" => 56500,
                "City" => "Ploeren",
                "Surface" => 12000,
                "Prix" => 500,
                "Type" => "Location",
                "Categorie" => "Bois"
            ],
            [
                "Reference" => "344334UJ",
                "Intitule" => "Sapinière",
                "Descriptif" => "Sapinière en cours de bail, cherche reprise",
                "Localisation" => 35200,
                "City" => "Rennes",
                "Surface" => 18000,
                "Prix" => 800,
                "Type" => "Location",
                "Categorie" => "Bois"
            ],
            [
                "Reference" => "QDSGF56",
                "Intitule" => "Bois domainial",
                "Descriptif" => "Bois accessible avec sentiers",
                "Localisation" => 44110,
                "City" => "Chateaubriant",
                "Surface" => 320000,
                "Prix" => 12000,
                "Type" => "Location",
                "Categorie" => "Bois"
            ],
            [
                "Reference" => "313453DR",
                "Intitule" => "Idéal société de chasse",
                "Descriptif" => "Terrain boisé classé ONF",
                "Localisation" => 22700,
                "City" => "Paimpol",
                "Surface" => 350000,
                "Prix" => 120000,
                "Type" => "Vente",
                "Categorie" => "Bois"
            ],
            [
                "Reference" => "345E7EG",
                "Intitule" => "Bois sur pied",
                "Descriptif" => "Diverses essences sur place",
                "Localisation" => 29510,
                "City" => "Plougasnou",
                "Surface" => 60000,
                "Prix" => 30000,
                "Type" => "Vente",
                "Categorie" => "Bois"
            ],
            [
                "Reference" => "81EL11100",
                "Intitule" => "Secteur du Ségala-Viaur",
                "Descriptif" => "les secteurs les plus en pente sont empiérés",
                "Localisation" => 12200,
                "City" => "Millau",
                "Surface" => 540000,
                "Prix" => 400000,
                "Type" => "Vente",
                "Categorie" => "Bois"
            ],
            [
                "Reference" => "48EL11345",
                "Intitule" => "Propriété Lozère",
                "Descriptif" => "Ensemble bâti avec environ 1ha55",
                "Localisation" => 48370,
                "City" => "Saint-Privat",
                "Surface" => 15500,
                "Prix" => 700,
                "Type" => "Location",
                "Categorie" => "Batiments"
            ],
            [
                "Reference" => "23.16.104",
                "Intitule" => "Propriété Creuse",
                "Descriptif" => "Dans un hameau à moins de 10 minutes d'un bourg avec services et commerces, et d'un village ayant un intérêt touristique sur les routes de St-Jacques-de-Compostelle.",
                "Localisation" => 23320,
                "City" => "Saint-Martin-Terressus",
                "Surface" => 15500,
                "Prix" => 860,
                "Type" => "Location",
                "Categorie" => "Batiments"
            ],
            [
                "Reference" => "64.03.60",
                "Intitule" => "Propriété située dans un secteur vallonné",
                "Descriptif" => "Propriété Pyrénées-Atlantiques",
                "Localisation" => 23500,
                "City" => "Saint-Paul-de-Jarrat",
                "Surface" => 60000,
                "Prix" => 650,
                "Type" => "Location",
                "Categorie" => "Batiments"
            ],
            [
                "Reference" => "44 22 AN 08",
                "Intitule" => "Bâtiments avicoles à transmettre",
                "Descriptif" => "Site avicole à transmettre sur la commune de Nort-sur-Erdre, au nord de Nantes.",
                "Localisation" => 44220,
                "City" => "Nort-sur-Erdre",
                "Surface" => 20000,
                "Prix" => 200000,
                "Type" => "Vente",
                "Categorie" => "Batiments"
            ],
            [
                "Reference" => "34VI6979",
                "Intitule" => "Propriété viticole et sa cave",
                "Descriptif" => "Au cœur de l'appellation Saint-Chinian",
                "Localisation" => 34280,
                "City" => "Saint-Chinian",
                "Surface" => 300000,
                "Prix" => 1500000,
                "Type" => "Vente",
                "Categorie" => "Batiments"
            ],
            [
                "Reference" => "34AG10897",
                "Intitule" => "Tourisme rural-hébergement",
                "Descriptif" => "Au nord de l'Hérault, proche des axes routiers et à 45 minutes de Montpellier",
                "Localisation" => 34070,
                "City" => "Montpellier",
                "Surface" => 19000,
                "Prix" => 1490000,
                "Type" => "Vente",
                "Categorie" => "Batiments"
            ],
            [
                "Reference" => "30VI9700",
                "Intitule" => "Propriété Gard",
                "Descriptif" => "Ensemble immobilier proche d'un plan d'eau aménagé",
                "Localisation" => 34290,
                "City" => "Saint-André-de-Majencoules",
                "Surface" => 290000,
                "Prix" => 2000,
                "Type" => "Location",
                "Categorie" => "Exploitations"
            ],
            [
                "Reference" => "19.07.118",
                "Intitule" => "FERME 100% HERBAGERE/ ELEVAGE LAITIER",
                "Descriptif" => "Située à l'orée d'un bourg, à 10 minutes des services et commerces.",
                "Localisation" => 35200,
                "City" => "Rennes",
                "Surface" => 340000,
                "Prix" => 950,
                "Type" => "Location",
                "Categorie" => "Exploitations"
            ],
            [
                "Reference" => "55VS",
                "Intitule" => "Propriété Meuse",
                "Descriptif" => "FERME DE COURUPT : Secteur Sainte-Menehould / Clermont-en-Argonne / Revigny",
                "Localisation" => 88340,
                "City" => "Sainte-Menehould",
                "Surface" => 590000,
                "Prix" => "Nous consulter",
                "Type" => "Location",
                "Categorie" => "Exploitations"
            ],
            [
                "Reference" => "MQ14170356",
                "Intitule" => "Propriété Calvados",
                "Descriptif" => "JFD : Noue de Sienne (14)",
                "Localisation" => 14380,
                "City" => "Noue de Sienne",
                "Surface" => 170000,
                "Prix" => 173440,
                "Type" => "Vente",
                "Categorie" => "Exploitations"
            ],
            [
                "Reference" => "17.03.017",
                "Intitule" => "Activités Equestres, Apiculture, Chasse,",
                "Descriptif" => "Propriété Charente-Maritime",
                "Localisation" => 17200,
                "City" => "Saint-Sulpice-de-Royan",
                "Surface" => 170000,
                "Prix" => 330000,
                "Type" => "Vente",
                "Categorie" => "Exploitations"
            ],
            [
                "Reference" => "AA 72 22 0088 RB",
                "Intitule" => "Exploitation Agricole spécialisée en polyculture élevage",
                "Descriptif" => "Exploitation située dans le Sud Est de La Sarthe, entre la commune d'Ecommoy (72220) et Sarcé (72327)",
                "Localisation" => 72220,
                "City" => "Ecommoy",
                "Surface" => 870000,
                "Prix" => "Nous consulter",
                "Type" => "Vente",
                "Categorie" => "Exploitations"
            ]
        ];


        // Créer 5 utilisateurs dont un avec le rôle admin
        for ($i = 0; $i < 4; $i++) {
            $user = new User();
            $user->setEmail('user' . $i . '@safer.com');
            $user->setFirstName('John ' . $i);
            $user->setLastName('Doe');
            $user->setPhone("0299763546");
            $user->setIsVerified($i != 3);
            $user->setPassword($this->passwordHasher->hashPassword($user, 'password'));
            $manager->persist($user);
        }

        // Créer un utilisateur avec le rôle admin
        $admin = new User();
        $admin->setEmail('admin@safer.com');
        $admin->setFirstName('John Admin');
        $admin->setLastName('Doe');
        $admin->setPhone("0654672311");
        $admin->setIsVerified(true);
        $admin->setPassword($this->passwordHasher->hashPassword($admin, 'password'));
        $admin->setRoles(['ROLE_ADMIN']);
        $manager->persist($admin);

        $manager->flush();


        // Créer les catégories du dataFixtures
        $categories = [];

        foreach ($dataSet as $data) {
            $category = $data['Categorie'];
            if (!in_array($category, $categories)) {
                $categories[] = $category;

                $categorie = new Category();
                $categorie->setName($data['Categorie']);
                $manager->persist($categorie);
            }
        }

        $manager->flush();

        // Pour chaque catégorie dans dataSet, on crée un object de type Catégorie
        foreach ($dataSet as $data) {

            $category = $manager->getRepository(Category::class)->findOneBy(['name' => $data['Categorie']]);

            $image = new Image();

            // Vérifier que le fichier existe dans le dossier public/image/property
            if (file_exists('public/image/property/' . $data['Reference'] . '.jpg')) {
                $image->setImageName($data['Reference'] . '.jpg');
            } else {
                $image->setImageName('default.jpg');
            }

            $manager->persist($image);

            // Créer un objet de type Property
            $property = new Property();
            $property->setReference($data['Reference']);
            $property->setTitle($data['Intitule']);
            $property->setDescription($data['Descriptif']);
            $property->setSurface($data['Surface']);
            $property->setZipCode($data['Localisation']);
            $property->setCity($data['City']);
            $property->setSurface($data['Surface']);
            $property->setPrice($data['Prix'] == "Nous consulter" ? null : $data['Prix']);
            $property->setType($data['Type']);
            $property->setCategory($category);
            $property->setAuthor($admin);
            $property->addImage($image);
            $manager->persist($property);
        }

        $manager->flush();
    }
}
