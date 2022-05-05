<?php
namespace App\DataFixtures;
use App\Entity\Service;
use App\Entity\Category;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;




class AppFixtures extends Fixture
{
    const CATEGORIES =[
        'Formations',
        'Loisirs',
        'Business',
        'Design',
        'Développement web',
        'Autres'
    ];

    const USERS =[
        'lealondero@gmail.com',
        'clementlaforge@gmail.com',
        'alexandralondero@sfr.fr',
    ];

  
    public function load(ObjectManager $manager)
    {
        $this->loadCategory($manager);
        $this->loadUser($manager);
        $this->loadService($manager);
    }


    /**
     * Alimenter l'entité Service.
     */
    public function loadService(ObjectManager $manager)
    {
        foreach ($this->getServiceData() as $index => [$title, $description, $expireAt]) {
            $Service = new Service();
            $Service->setTitle($title)
            ->setDescription($description)
            ->setExpireAt($expireAt)
            ->setCreatedAt(new \DateTimeImmutable())
            ->setCategory($this->getReference('categorie-' . random_int(1,count(self::CATEGORIES)) ))
            ->setUser( $this->getReference('user-' . random_int(1,count(self::USERS)) ) );
            $manager->persist($Service);
        }
        $manager->flush();
    }

    /**
    * Alimenter l'entité Category.
    */
    public function loadCategory(ObjectManager $manager)
    {
        foreach (self::CATEGORIES as $index => $description) {
            $category = new Category();
            $category->setDescription($description)
            ->setCreatedAt(new \DateTimeImmutable());
            // Persister
            $manager->persist($category);
            // Référencer la catégorie
            $this->addReference('categorie-' . ($index + 1), $category);
        }
        $manager->flush();
    }

    /**
    * Alimenter l'entité User.
    */
    public function loadUser(ObjectManager $manager)
    {
        foreach (self::USERS as $index => $login) {
            $user = new User();
            $user->setemail($login)
            ->setPassword("jsp")
            ->setName("jsp");
            // Persister
            $manager->persist($user);
            // Référencer l'utilisateur
            $this->addReference('user-' . ($index + 1), $user);
        }
        $manager->flush();
    }
    // // TODO alimenter l'entité User 


    /**
     * Produire le tableau des données pour les articles.
    * Chaque élément du tableau contient :
    * title, description, publishedAt
    */
    private function getServiceData(): array
    {
        $datas = [];
        for ($i = 1; $i <= 10; $i++) {
            $datas[] = [
            $this->getOnePhrase(),
            $this->getText(),
            new \DateTimeImmutable('2020-' . random_int(1, 12) . '-' . random_int(1,
            30)),
            ];
        }
        return $datas;
    }
    
    /**
     * Retourne une phrase au hasard.
     */
    private function getOnePhrase(): string
    {
        $phrases = $this->getPhrases();
        return $phrases[random_int(0, count($phrases) - 1)];
    }

    /**
     * Retourne un texte au hasard.
     */
    private function getText(): string
    {
        $phrases = $this->getPhrases();
        shuffle($phrases);
        $sz = '';
        for ($i = 0; $i < random_int(3, count($phrases) - 1); $i++) {
        $sz .= $phrases[$i] . '.';
        }
        return $sz;
    }

    private function getPhrases(): array
    {
        return [
        'Lorem ipsum dolor sit amet consectetur adipiscing elit',
        'Pellentesque vitae velit ex',
        'Mauris dapibus risus quis suscipit vulputate',
        'Eros diam egestas libero eu vulputate risus',
        'In hac habitasse platea dictumst',
        'Morbi tempus commodo mattis',
        'Ut suscipit posuere justo at vulputate',
        'Ut eleifend mauris et risus ultrices egestas',
        'Aliquam sodales odio id eleifend tristique',
        'Urna nisl sollicitudin id varius orci quam id turpis',
        'Nulla porta lobortis ligula vel egestas',
        'Curabitur aliquam euismod dolor non ornare',
        'Sed varius a risus eget aliquam',
        'Nunc viverra elit ac laoreet suscipit',
        'Pellentesque et sapien pulvinar consectetur',
        'Ubi est barbatus nix',
        'Abnobas sunt hilotaes de placidus vita',
        'Ubi est audax amicitia',
        'Eposs sunt solems de superbus fortis',
        'Vae humani generis',
        'Diatrias tolerare tanquam noster caesium',
        'Teres talis saepe tractare de camerarius flavum sensorem',
        'Silva de secundus galatae demitto quadra',
        'Sunt accentores vitare salvus flavum parses',
        'Potus sensim ad ferox abnoba',
        'Sunt seculaes transferre talis camerarius fluctuies',
        'Era brevis ratione est',
        'Sunt torquises imitari velox mirabilis medicinaes',
        'Mineralis persuadere omnes finises desiderium',
        'Bassus fatalis classiss virtualiter transferre de flavum',
        ];
    }
}