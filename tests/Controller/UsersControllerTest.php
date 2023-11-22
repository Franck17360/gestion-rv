<?php

namespace App\Test\Controller;

use App\Entity\Users;
use App\Repository\UsersRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UsersControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private UsersRepository $repository;
    private string $path = '/users/';
    private EntityManagerInterface $manager;

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = static::getContainer()->get('doctrine')->getRepository(Users::class);

        foreach ($this->repository->findAll() as $object) {
            $this->manager->remove($object);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('User index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $originalNumObjectsInRepository = count($this->repository->findAll());

        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'user[Name]' => 'Testing',
            'user[FirstName]' => 'Testing',
            'user[Address]' => 'Testing',
            'user[ZipCode]' => 'Testing',
            'user[Town]' => 'Testing',
            'user[Email]' => 'Testing',
            'user[Phone]' => 'Testing',
            'user[Role]' => 'Testing',
            'user[Function]' => 'Testing',
        ]);

        self::assertResponseRedirects('/users/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Users();
        $fixture->setName('My Title');
        $fixture->setFirstName('My Title');
        $fixture->setAddress('My Title');
        $fixture->setZipCode('My Title');
        $fixture->setTown('My Title');
        $fixture->setEmail('My Title');
        $fixture->setPhone('My Title');
        $fixture->setRole('My Title');
        $fixture->setFunction('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('User');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Users();
        $fixture->setName('My Title');
        $fixture->setFirstName('My Title');
        $fixture->setAddress('My Title');
        $fixture->setZipCode('My Title');
        $fixture->setTown('My Title');
        $fixture->setEmail('My Title');
        $fixture->setPhone('My Title');
        $fixture->setRole('My Title');
        $fixture->setFunction('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'user[Name]' => 'Something New',
            'user[FirstName]' => 'Something New',
            'user[Address]' => 'Something New',
            'user[ZipCode]' => 'Something New',
            'user[Town]' => 'Something New',
            'user[Email]' => 'Something New',
            'user[Phone]' => 'Something New',
            'user[Role]' => 'Something New',
            'user[Function]' => 'Something New',
        ]);

        self::assertResponseRedirects('/users/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getName());
        self::assertSame('Something New', $fixture[0]->getFirstName());
        self::assertSame('Something New', $fixture[0]->getAddress());
        self::assertSame('Something New', $fixture[0]->getZipCode());
        self::assertSame('Something New', $fixture[0]->getTown());
        self::assertSame('Something New', $fixture[0]->getEmail());
        self::assertSame('Something New', $fixture[0]->getPhone());
        self::assertSame('Something New', $fixture[0]->getRole());
        self::assertSame('Something New', $fixture[0]->getFunction());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new Users();
        $fixture->setName('My Title');
        $fixture->setFirstName('My Title');
        $fixture->setAddress('My Title');
        $fixture->setZipCode('My Title');
        $fixture->setTown('My Title');
        $fixture->setEmail('My Title');
        $fixture->setPhone('My Title');
        $fixture->setRole('My Title');
        $fixture->setFunction('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/users/');
    }
}
