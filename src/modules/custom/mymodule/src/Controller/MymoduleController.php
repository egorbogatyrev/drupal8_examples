<?php

namespace Drupal\mymodule\Controller;

use Drupal\Component\Utility\Xss;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Datetime\DateFormatterInterface;
use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Drupal\Core\Entity\Controller\EntityViewController;
use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Render\RendererInterface;
use Drupal\Core\Url;
use Drupal\mymodule\Entity\MymoduleTypeInterface;
use Drupal\mymodule\Entity\mymoduleInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Returns responses for Mymodule routes.
 */
class MymoduleController extends ControllerBase implements ContainerInjectionInterface {

  /**
   * The date formatter service.
   *
   * @var \Drupal\Core\Datetime\DateFormatterInterface
   */
  protected $dateFormatter;

  /**
   * The renderer service.
   *
   * @var \Drupal\Core\Render\RendererInterface
   */
  protected $renderer;

  /**
   * Constructs a MymoduleController object.
   *
   * @param \Drupal\Core\Datetime\DateFormatterInterface $date_formatter
   *   The date formatter service.
   * @param \Drupal\Core\Render\RendererInterface $renderer
   *   The renderer service.
   */
  public function __construct(DateFormatterInterface $date_formatter, RendererInterface $renderer) {
    $this->dateFormatter = $date_formatter;
    $this->renderer = $renderer;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('date.formatter'),
      $container->get('renderer')
    );
  }

  /**
   * Displays add content links for available content types.
   *
   * Redirects to mymodule/add/[type] if only one content type is available.
   *
   * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
   *   A render array for a list of the mymodule types that can be added;
   *   however, if there is only one mymodule type defined for the site,
   *   the function will return a RedirectResponse to the mymodule add page
   *   for that one mymodule type.
   */
  public function addPage() {
    $build = [
      '#theme' => 'mymodule_content_add_list',
      '#cache' => [
        'tags' => static::entityTypeManager()->getDefinition('mymodule_type')->getListCacheTags(),
      ],
    ];

    $content = [];

    // Only use mymodule types the user has access to.
    foreach (static::entityTypeManager()->getStorage('mymodule_type')->loadMultiple() as $type) {
      $access = static::entityTypeManager()->getAccessControlHandler('mymodule')->createAccess($type->id(), NULL, [], TRUE);
      if ($access->isAllowed()) {
        $content[$type->id()] = $type;
      }
      $this->renderer->addCacheableDependency($build, $access);
    }

    // Bypass the mymodule/add listing if only one content type is available.
    if (count($content) == 1) {
      $type = array_shift($content);
      return $this->redirect('entity.mymodule.add_form', ['mymodule_type' => $type->id()]);
    }
    $build['#content'] = $content;

    return $build;
  }

  /**
   * Provides the mymodule submission form.
   *
   * @param \Drupal\mymodule\Entity\MymoduleTypeInterface $mymodule_type
   *   The mymodule type entity for the mymodule.
   *
   * @return array
   *   A mymodule submission form.
   */
  public function addForm(MymoduleTypeInterface $mymodule_type) {
    $mymodule = static::entityTypeManager()->getStorage('mymodule')->create([
      'type' => $mymodule_type->id(),
    ]);
    $form = $this->entityFormBuilder()->getForm($mymodule);

    return $form;
  }






  /**
   * Displays a mymodule revision.
   *
   * @param int $mymodule_revision
   *   The mymodule revision ID.
   *
   * @return array
   *   An array suitable for drupal_render().
   */
  public function revisionShow($mymodule_revision) {
    $mymodule = static::entityTypeManager()->getStorage('mymodule')->loadRevision($mymodule_revision);
    $mymodule = static::entityTypeManager()->getTranslationFromContext($mymodule);
    $mymodule_view_controller = new EntityViewController($this->entityManager, $this->renderer, $this->currentUser());
    $page = $mymodule_view_controller->view($mymodule);
    unset($page['mymodules'][$mymodule->id()]['#cache']);
    return $page;
  }

  /**
   * Page title callback for a mymodule revision.
   *
   * @param int $mymodule_revision
   *   The mymodule revision ID.
   *
   * @return string
   *   The page title.
   */
  public function revisionPageTitle($mymodule_revision) {
    $mymodule = static::entityTypeManager()->getStorage('mymodule')->loadRevision($mymodule_revision);
    return $this->t('Revision of %title from %date', ['%title' => $mymodule->label(), '%date' => format_date($mymodule->getRevisionCreationTime())]);
  }

  /**
   * Generates an overview table of older revisions of a mymodule.
   *
   * @param \Drupal\mymodule\Entity\MymoduleTypeInterface $mymodule
   *   A mymodule object.
   *
   * @return array
   *   An array as expected by drupal_render().
   */
  public function revisionOverview(MymoduleInterface $mymodule) {
    $account = $this->currentUser();
    $langcode = $mymodule->language()->getId();
    $langname = $mymodule->language()->getName();
    $languages = $mymodule->getTranslationLanguages();
    $has_translations = (count($languages) > 1);
    $mymodule_storage = static::entityTypeManager()->getStorage('mymodule');
    $type = $mymodule->getType();

    $build['#title'] = $has_translations ? $this->t('@langname revisions for %title', ['@langname' => $langname, '%title' => $mymodule->label()]) : $this->t('Revisions for %title', ['%title' => $mymodule->label()]);
    $header = [$this->t('Revision'), $this->t('Operations')];

    $revert_permission = (($account->hasPermission("revert $type revisions") || $account->hasPermission('revert all revisions') || $account->hasPermission('administer mymodules')) && $mymodule->access('update'));
    $delete_permission = (($account->hasPermission("delete $type revisions") || $account->hasPermission('delete all revisions') || $account->hasPermission('administer mymodules')) && $mymodule->access('delete'));

    $rows = [];
    $default_revision = $mymodule->getRevisionId();

    foreach ($this->getRevisionIds($mymodule, $mymodule_storage) as $vid) {
      /** @var \Drupal\mymodule\Entity\MymoduleTypeInterface $revision */
      $revision = $mymodule_storage->loadRevision($vid);
      // Only show revisions that are affected by the language that is being
      // displayed.
      if ($revision->hasTranslation($langcode) && $revision->getTranslation($langcode)->isRevisionTranslationAffected()) {
        $username = [
          '#theme' => 'username',
          '#account' => $revision->getRevisionUser(),
        ];

        // Use revision link to link to revisions that are not active.
        $date = $this->dateFormatter->format($revision->revision_timestamp->value, 'short');
        if ($vid != $mymodule->getRevisionId()) {
          $link = $this->l($date, new Url('entity.mymodule.revision', ['mymodule' => $mymodule->id(), 'mymodule_revision' => $vid]));
        }
        else {
          $link = $mymodule->link($date);
        }

        $row = [];
        $column = [
          'data' => [
            '#type' => 'inline_template',
            '#template' => '{% trans %}{{ date }} by {{ username }}{% endtrans %}{% if message %}<p class="revision-log">{{ message }}</p>{% endif %}',
            '#context' => [
              'date' => $link,
              'username' => $this->renderer->renderPlain($username),
              'message' => ['#markup' => $revision->revision_log->value, '#allowed_tags' => Xss::getHtmlTagList()],
            ],
          ],
        ];
        // @todo Simplify once https://www.drupal.org/mymodule/2334319 lands.
        $this->renderer->addCacheableDependency($column['data'], $username);
        $row[] = $column;

        if ($vid == $default_revision) {
          $row[] = [
            'data' => [
              '#prefix' => '<em>',
              '#markup' => $this->t('Current revision'),
              '#suffix' => '</em>',
            ],
          ];

          $rows[] = [
            'data' => $row,
            'class' => ['revision-current'],
          ];
        }
        else {
          $links = [];
          if ($revert_permission) {
            $links['revert'] = [
              'title' => $vid < $mymodule->getRevisionId() ? $this->t('Revert') : $this->t('Set as current revision'),
              'url' => $has_translations ?
                Url::fromRoute('mymodule.revision_revert_translation_confirm', ['mymodule' => $mymodule->id(), 'mymodule_revision' => $vid, 'langcode' => $langcode]) :
                Url::fromRoute('mymodule.revision_revert_confirm', ['mymodule' => $mymodule->id(), 'mymodule_revision' => $vid]),
            ];
          }

          if ($delete_permission) {
            $links['delete'] = [
              'title' => $this->t('Delete'),
              'url' => Url::fromRoute('mymodule.revision_delete_confirm', ['mymodule' => $mymodule->id(), 'mymodule_revision' => $vid]),
            ];
          }

          $row[] = [
            'data' => [
              '#type' => 'operations',
              '#links' => $links,
            ],
          ];

          $rows[] = $row;
        }
      }
    }

    $build['mymodule_revisions_table'] = [
      '#theme' => 'table',
      '#rows' => $rows,
      '#header' => $header,
      '#attached' => [
        'library' => ['mymodule/drupal.mymodule.admin'],
      ],
      '#attributes' => ['class' => 'mymodule-revision-table'],
    ];

    $build['pager'] = ['#type' => 'pager'];

    return $build;
  }

  /**
   * The _title_callback for the mymodule.add route.
   *
   * @param \Drupal\mymodule\Entity\MymoduleTypeInterface $mymodule_type
   *   The current mymodule.
   *
   * @return string
   *   The page title.
   */
  public function addPageTitle(MymoduleTypeInterface $mymodule_type) {
    return $this->t('Create @name', ['@name' => $mymodule_type->label()]);
  }

  /**
   * Gets a list of mymodule revision IDs for a specific mymodule.
   *
   * @param \Drupal\mymodule\Entity\MymoduleTypeInterface $mymodule
   *   The mymodule entity.
   * @param \Drupal\Core\Entity\EntityStorageInterface $mymodule_storage
   *   The mymodule storage handler.
   *
   * @return int[]
   *   mymodule revision IDs (in descending order).
   */
  protected function getRevisionIds(mymoduleInterface $mymodule, EntityStorageInterface $mymodule_storage) {
    $result = $mymodule_storage->getQuery()
      ->allRevisions()
      ->condition($mymodule->getEntityType()->getKey('id'), $mymodule->id())
      ->sort($mymodule->getEntityType()->getKey('revision'), 'DESC')
      ->pager(50)
      ->execute();
    return array_keys($result);
  }

}
