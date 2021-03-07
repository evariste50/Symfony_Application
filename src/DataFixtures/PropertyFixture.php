<?php
namespace App\DataFixtures;




use App\Entity\Property;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;


/**
 * permet de creer aleatoiremrnt 100 bien dans notre base de donnee
 */
class PropertyFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {
        
        for($i=0; $i < 100 ;$i++)
        {
            $property = new Property();
            $property
                    ->setTitle("Ma Superbe Agence", $i)
                    ->setDescription("Une petite description de rien du tous ",$i)
                    ->setSurface(3, $i)
                    ->setRooms(2,$i)
                    ->setBedrooms(1,$i)
                    ->setFloor(5, $i)
                    ->setPrice(10000,$i)
                    ->setHeat(0, $i)
                    ->setCity("yaounde", $i)
                    ->setAddress("15 rue yaounde", $i)
                    ->setPostalCode("35000",$i)
                    ->setSold(false, $i);
                    
            $manager->persist($property);
        }

        $manager->flush();
    }
}
