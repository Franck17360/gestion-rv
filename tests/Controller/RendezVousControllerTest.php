<?php

namespace App\Test\Controller;

use App\Entity\RendezVous;
use App\Repository\RendezVousRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RendezVousControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private RendezVousRepository $repository;
    private string $path = '/rendez/vous/';
    private EntityManagerInterface $manager;

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = static::getContainer()->get('doctrine')->getRepository(RendezVous::class);

        foreach ($this->repository->findAll() as $object) {
            $this->manager->remove($object);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('RendezVou index');

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
            'rendez_vou[DateRendezVous]' => 'Testing',
            'rendez_vou[Heure]' => 'Testing',
            'rendez_vou[Lieu]' => 'Testing',
            'rendez_vou[Description]' => 'Testing',
        ]);

        self::assertResponseRedirects('/rendez/vous/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new RendezVous();
        $fixture->setDateRendezVous('My Title');
        $fixture->setHeure('My Title');
        $fixture->setLieu('My Title');
        $fixture->setDescription('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('RendezVou');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new RendezVous();
        $fixture->setDateRendezVous('My Title');
        $fixture->setHeure('My Title');
        $fixture->setLieu('My Title');
        $fixture->setDescription('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'rendez_vou[DateRendezVous]' => 'Something New',
            'rendez_vou[Heure]' => 'Something New',
            'rendez_vou[Lieu]' => 'Something New',
            'rendez_vou[Description]' => 'Something New',
        ]);

        self::assertResponseRedirects('/rendez/vous/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getDateRendezVous());
        self::assertSame('Something New', $fixture[0]->getHeure());
        self::assertSame('Something New', $fixture[0]->getLieu());
        self::assertSame('Something New', $fixture[0]->getDescription());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new RendezVous();
        $fixture->setDateRendezVous('My Title');
        $fixture->setHeure('My Title');
        $fixture->setLieu('My Title');
        $fixture->setDescription('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/rendez/vous/');
    }
}
