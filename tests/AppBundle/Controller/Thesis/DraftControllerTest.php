<?php

namespace AppBundle\Tests\Controller\Thesis;

use AppBundle\Entity\Draft;
use AppBundle\Entity\Feedback;
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

        $dummyFile = __DIR__.'/../../../dummy_file.zip';
        $form['form[file]']->upload($dummyFile);

        $comment = 'Minor changes in descriptions, added diagrams.';
        $form['form[comment]']->setValue($comment);

        $crawler = $client->submit($form);

        $this->assertGreaterThan(
            0,
            $crawler->filter('html:contains("You successfully uploaded a new draft")')->count()
        );

        $this->assertGreaterThan(
            0,
            $crawler->filter('html:contains("'.$comment.'")')->count()
        );

        /** @var Draft $draft */
        $draft = $client->getKernel()->getContainer()->get('draft.repository')->findOneByComment($comment);

        $this->assertInstanceOf(Draft::class, $draft);
        $this->assertEquals($comment, $draft->getComment());

        // file was uploaded
        $this->assertEquals(
            filesize($dummyFile),
            filesize($client->getKernel()->getContainer()->getParameter('drafts_directory').'/'.$draft->getFilename())
        );
    }

    public function testUnableToUploadDraftOfAThesisBefore24h()
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

    /**
     * 1. Login as supervisor
     * 2. Select supervised theses list
     * 3. Choose a thesis
     * 4. Choose to view drafts
     * 5. Request to add feedback on chosen draft
     * 6. Fill the form
     * 7. Click submit
     * 8. Expect success
     */
    public function testAddFeedbackToADraft()
    {
        $client = static::createClient();
        $client->followRedirects();

        $crawler = $client->request('POST', '/login', [
            '_email' => 't1@example.org',
            '_pass' => '123'
        ]);

        $link = $crawler->filter('ul.navbar-nav')->filter('li.dropdown')->selectLink('Supervised theses');
        $crawler = $client->click($link->link());

        $link = $crawler->filter('.theses-list--table')->selectLink('Details')->first();
        $crawler = $client->click($link->link());

        $link = $crawler->filter('div.theses-list--panel')->selectLink('Drafts');
        $crawler = $client->click($link->link());

        $link = $crawler->filter('div.drafts-list')->selectLink('Add feedback');
        $crawler = $client->click($link->link());

        $form = $crawler->selectButton('Submit')->form();

        $dummyFile = __DIR__.'/../../../dummy_file.pdf';
        $form['form[file]']->upload($dummyFile);

        $comment = 'Very good, minor fiex to do - underlined in the pdf.';
        $form['form[comment]']->setValue($comment);

        $crawler = $client->submit($form);

        // success message and proper page
        $this->assertGreaterThan(
            0,
            $crawler->filter('html:contains("You successfully added a feedback")')->count()
        );

        $this->assertGreaterThan(
            0,
            $crawler->filter('html:contains("'.$comment.'")')->count()
        );

        // feedback was saved to dabase
        /** @var Feedback $feedback */
        $feedback = $client->getKernel()->getContainer()->get('feedback.repository')->findOneByContent($comment);

        $this->assertInstanceOf(Feedback::class, $feedback);
        $this->assertEquals($comment, $feedback->getContent());

        // file was uploaded
        $this->assertEquals(
            filesize($dummyFile),
            filesize($client->getKernel()->getContainer()->getParameter('feedbacks_directory').'/'.$feedback->getFilename())
        );
    }
}
