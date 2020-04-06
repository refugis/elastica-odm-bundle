<?php declare(strict_types=1);

namespace Tests\Fixtures\DependencyInjection\Controller;

use Refugis\ODM\Elastica\DocumentManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Tests\Fixtures\Document\Foo;

class TestController extends AbstractController
{
    public function testAction(DocumentManagerInterface $documentManager): Response
    {
        $foo = new Foo();
        $documentManager->persist($foo);
        $foo->stringField = 'test';

        $documentManager->flush();

        $documents = $documentManager->getRepository(Foo::class)->findAll();

        return new Response((string) \count($documents));
    }
}
