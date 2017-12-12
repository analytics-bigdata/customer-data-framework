<?php
/**
 * @var \Pimcore\Templating\PhpEngine $this
 * @var \Pimcore\Templating\PhpEngine $view
 * @var \Pimcore\Templating\GlobalVariables $app
 *
 * @var array $clearUrlParams
 * @var \Pimcore\Model\DataObject\CustomerSegmentGroup[] $segmentGroups
 * @var array $filters
 * @var \CustomerManagementFrameworkBundle\CustomerView\CustomerViewInterface $customerView
 * @var \CustomerManagementFrameworkBundle\Model\CustomerView\FilterDefinition $filterDefinition
 */
/** @noinspection PhpUndefinedMethodInspection */
$this->jsConfig()->add('registerSaveFilterDefinition', true);
/** @noinspection PhpUndefinedMethodInspection */
$this->jsConfig()->add('registerUpdateFilterDefinition', true);
/** @noinspection PhpUndefinedMethodInspection */
$this->jsConfig()->add('registerShareFilterDefinition', true);
?>

</div>
<!-- /.box-body -->

<div class="box-footer text-right">
    <?php
    // check if user is allowed user for filter and doesn't have admin permission
    if ($filterDefinition->getId()
        && $filterDefinition->isUserAllowed(\Pimcore\Tool\Admin::getCurrentUser()->getId())
        && !\Pimcore\Tool\Admin::getCurrentUser()->isAllowed('plugin_cmf_perm_customerview_admin')) :
        ?>
        <button type="button" class="btn btn-primary" data-toggle="modal"
                data-target="#share-filter-definition-modal">
            <i class="fa fa-share"></i>&nbsp;<?= $customerView->translate('Share Filter') ?></button>
        <div id="share-filter-definition-modal" class="modal fade text-left" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title pull-left"><?= $customerView->translate('Share the filter') ?></h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <?= $this->template('PimcoreCustomerManagementFrameworkBundle:Admin/Customers/partials/list-filter:user-roles.html.php',['preselected' => false]) ?>
                    </div>
                    <div class="modal-footer">
                        <input type="button" class="btn btn-default" value="Cancel" data-dismiss="modal"/>
                        <a type="button" class="btn btn-primary" name="share-filter-definition"
                           id="share-filter-definition">
                            <?= $customerView->translate('Share'); ?>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <?php
    // check if user is customer view admin
    if (\Pimcore\Tool\Admin::getCurrentUser()->isAllowed('plugin_cmf_perm_customerview_admin')): ?>
        <?php if ($filterDefinition->getId()): ?>
            <button type="button" class="btn btn-danger" data-toggle="modal"
                    data-target="#delete-filter-definition-modal">
                <i class="fa fa-trash"></i>&nbsp;<?= $customerView->translate('Delete Filter') ?></button>
            <div id="delete-filter-definition-modal" class="modal fade text-left" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title pull-left"><?= $customerView->translate('Delete filter?') ?></h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-footer">
                            <input type="button" class="btn btn-default" value="Cancel" data-dismiss="modal"/>
                            <a class="btn btn-danger" href="<?= $this->url('cmf_filter_definition_delete',
                                ['filterDefinition' => ['id' => $filterDefinition->getId()]]); ?>"
                               name="delete-filter-definition">
                                <?= $customerView->translate('Delete') ?>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <button type="button" class="btn btn-default" data-toggle="modal" data-target="#save-filter-definition-modal"><i
                    class="fa fa-save"></i>&nbsp;<?= $customerView->translate('Save & Share Filter') ?></button>
        <div id="save-filter-definition-modal" class="modal fade text-left" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title pull-left"><?= $customerView->translate('Save your filter') ?></h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">

                        <div class="alert alert-danger" style="display: none;" id="name-required-message">
                            <?= $customerView->translate('Name is required') ?>
                        </div>

                        <div class="row">
                            <div class="col-xs-12">
                                <div class="form-group">
                                    <label for="filterDefinition[name]"><?= $customerView->translate('Filter name') ?></label>
                                    <input type="text" name="filterDefinition[name]" id="filterDefinition[name]"
                                           class="form-control"
                                           placeholder="<?= $customerView->translate('Filter name') ?>"
                                           value="<?= $filterDefinition->getName() ?>">
                                </div>
                            </div>
                        </div>

                        <?= $this->template('PimcoreCustomerManagementFrameworkBundle:Admin/Customers/partials/list-filter:user-roles.html.php', ['preselected' => true]) ?>

                        <div class="row">
                            <div class="col-xs-6">
                                <div class="checkbox plugin-icheck">
                                    <label for="filterDefinition[readOnly]">
                                        <input type="checkbox" name="filterDefinition[readOnly]"
                                               id="filterDefinition[readOnly]"<?= $filterDefinition->isReadOnly() ? ' checked="checked"' : '' ?>>
                                        <?= $customerView->translate('Read Only'); ?>
                                    </label>
                                </div>
                            </div>
                            <div class="col-xs-6">
                                <div class="checkbox plugin-icheck">
                                    <label for="filterDefinition[shortcutAvailable]">
                                        <input type="checkbox" name="filterDefinition[shortcutAvailable]"
                                               id="filterDefinition[shortcutAvailable]"<?= $filterDefinition->isShortcutAvailable() ? ' checked="checked"' : '' ?>>
                                        <?= $customerView->translate('Shortcut Available'); ?>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="button" class="btn btn-default" value="<?= $customerView->translate('Cancel'); ?>"
                               data-dismiss="modal"/>
                        <?php if ($filterDefinition->getId()): ?>
                            <a type="button" class="btn btn-primary" name="update-filter-definition"
                               id="update-filter-definition"><i class="fa fa-save"></i>
                                <?= $customerView->translate('Update existing Filter'); ?>
                            </a>
                        <?php endif; ?>
                        <a type="button" class="btn btn-success" name="save-filter-definition"
                           id="save-filter-definition"><i class="fa fa-plus"></i>
                            <?= $customerView->translate('Save as new filter'); ?>
                        </a>

                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <a href="<?= $this->selfUrl()->get(true, $this->addPerPageParam()->add($clearUrlParams ?: [])) ?>"
       class="btn btn-default">
        <i class="fa fa-ban"></i>
        <?= $customerView->translate('Clear Filters'); ?>
    </a>

    <button type="submit" class="btn btn-primary">
        <i class="fa fa-filter"></i>
        <?= $customerView->translate('Apply Filters'); ?>
    </button>
</div>
<!-- /.box-footer -->

</form>
</div>
