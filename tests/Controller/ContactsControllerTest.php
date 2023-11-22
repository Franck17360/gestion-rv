<?php

namespace App\Test\Controller;

use App\Entity\Contacts;
use App\Repository\ContactsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ContactsControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private ContactsRepository $repository;
    private string $path = '/contacts/';
    private EntityManagerInterface $manager;

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = static::getContainer()->get('doctrine')->getRepository(Contacts::class);

        foreach ($this->repository->findAll() as $object) {
            $this->manager->remove($object);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Contact index');

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
            'contact[Name]' => 'Testing',
            'contact[FirstName]' => 'Testing',
            'contact[password]' => 'Testing',
            'contact[Address]' => 'Testing',
            'contact[ZipCode]' => 'Testing',
            'contact[Town]' => 'Testing',
            'contact[Email]' => 'Testing',
            'contact[Phone]' => 'Testing',
            'contact[role]' => 'Testing',
            'contact[Objectif]' => 'Testing',
            'contact[Id]' => 'Testing',
        ]);

        self::assertResponseRedirects('/contacts/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Contacts();
        $fixture->setName('My Title');
        $fixture->setFirstName('My Title');
        $fixture->setPassword('My Title');
        $fixture->setAddress('My Title');
        $fixture->setZipCode('My Title');
        $fixture->setTown('My Title');
        $fixture->setEmail('My Title');
        $fixture->setPhone('My Title');
        $fixture->setRole('My Title');
        $fixture->setObjectif('My Title');
        $fixture->setId('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Contact');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Contacts();
        $fixture->setName('My Title');
        $fixture->setFirstName('My Title');
        $fixture->setPassword('My Title');
        $fixture->setAddress('My Title');
        $fixture->setZipCode('My Title');
        $fixture->setTown('My Title');
        $fixture->setEmail('My Title');
        $fixture->setPhone('My Title');
        $fixture->setRole('My Title');
        $fixture->setObjectif('My Title');
        $fixture->setId('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'contact[Name]' => 'Something New',
            'contact[FirstName]' => 'Something New',
            'contact[password]' => 'Something New',
            'contact[Address]' => 'Something New',
            'contact[ZipCode]' => 'Something New',
            'contact[Town]' => 'Something New',
            'contact[Email]' => 'Something New',
            'contact[Phone]' => 'Something New',
            'contact[role]' => 'Something New',
            'contact[Objectif]' => 'Something New',
            'contact[Id]' => 'Something New',
        ]);

        self::assertResponseRedirects('/contacts/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getName());
        self::assertSame('Something New', $fixture[0]->getFirstName());
        self::assertSame('Something New', $fixture[0]->getPassword());
        self::assertSame('Something New', $fixture[0]->getAddress());
        self::assertSame('Something New', $fixture[0]->getZipCode());
        self::assertSame('Something New', $fixture[0]->getTown());
        self::assertSame('Something New', $fixture[0]->getEmail());
        self::assertSame('Something New', $fixture[0]->getPhone());
        self::assertSame('Something New', $fixture[0]->getRole());
        self::assertSame('Something New', $fixture[0]->getObjectif());
        self::assertSame('Something New', $fixture[0]->getId());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new Contacts();
        $fixture->setName('My Title');
        $fixture->setFirstName('My Title');
        $fixture->setPassword('My Title');
        $fixture->setAddress('My Title');
        $fixture->setZipCode('My Title');
        $fixture->setTown('My Title');
        $fixture->setEmail('My Title');
        $fixture->setPhone('My Title');
        $fixture->setRole('My Title');
        $fixture->setObjectif('My Title');
        $fixture->setId('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/contacts/');
    }
}
