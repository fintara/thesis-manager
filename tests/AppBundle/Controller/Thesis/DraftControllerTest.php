<?php

namespace AppBundle\Tests\Controller\Thesis;

use AppBundle\Entity\Draft;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class DraftControllerTest extends WebTestCase
{
    /**
     * 1. Login as a student
     * 2. Select thesis
     * 3. Choose to view drafts
     * 4. Request to upload a draft
     * 5. Fill form
     * 6. Click submit
     * 7. Expect success
     */
    public function testUploadDraftOfAThesis()
    {
        $client = static::createClient();
        $client->followRedirects();

        $crawler = $client->request('POST', '/login', [
            '_email' => 's2@example.org',
            '_pass' => '123'
        ]);

        $crawler = $client->click($crawler->filter('ul.navbar-nav')->selectLink('Thesis')->link());
        $crawler = $client->click($crawler->filter('div.theses-list--panel')->selectLink('Drafts')->link());
        $crawler = $client->click($crawler->filter('div.theses-list--panel')->selectLink('Upload Draft')->link());
        $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());

        $form = $crawler->selectButton('Submit')->form();
        $form['form[file]']->upload(__DIR__.'/../../../dummy_file.zip');
        $comment = 'This is a feedback. Random content: '.rand(1000,9999);
        $form['form[comment]']->setValue($comment);

        $crawler = $client->submit($form);

        $this->assertGreaterThan(
            0,
            $crawler->filter('html:contains("You successfully uploaded a new draft")')->count()
        );

        /** @var Draft $draft */
        $draft = $client->getKernel()->getContainer()->get('draft.repository')->findOneByComment($comment);

        $this->assertInstanceOf(Draft::class, $draft);
        $this->assertEquals($comment, $draft->getComment());
    }

    public function testUnableToUploadDraftOfAThesis()
    {
        $client = static::createClient();
        $client->followRedirects();

        $crawler = $client->request('POST', '/login', [
            '_email' => 's3@example.org',
            '_pass' => '123'
        ]);

        $thesisLink = $crawler->filter('ul.navbar-nav')->filter('li.dropdown')->selectLink('An application for a private dental office');
        $crawler = $client->click($thesisLink->link());
        $crawler = $client->click($crawler->filter('div.theses-list--panel')->selectLink('Drafts')->link());

        $link = $crawler->filter('div.theses-list--panel')->selectLink('Upload Draft');

        $this->assertNotFalse(strstr($link->attr('class'), 'disabled'));
    }

    public function testAddFeedbackToADraft()
    {

    }
}
