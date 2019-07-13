<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="row">
    <div class="col-sm-12 col-xs-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo trans('update_page'); ?></h3>
            </div>
            <!-- /.box-header -->

            <!-- form start -->
            <?php echo form_open('page_controller/update_page_post'); ?>

            <input type="hidden" name="id" value="<?php echo html_escape($page->id); ?>">
            <input type="hidden" name="redirect_url" value="<?php echo $this->input->get('redirect_url'); ?>">
            <div class="box-body">
                <!-- include message block -->
                <?php $this->load->view('admin/includes/_messages'); ?>

                <div class="form-group">
                    <label class="control-label"><?php echo trans('title'); ?></label>
                    <input type="text" class="form-control" name="title" placeholder="<?php echo trans('title'); ?>"
                           value="<?php echo html_escape($page->title); ?>" <?php echo ($rtl == true) ? 'dir="rtl"' : ''; ?> required>
                </div>

                <?php if ($page->is_custom == 1): ?>
                    <div class="form-group">
                        <label class="control-label"><?php echo trans("slug"); ?>
                            <small>(<?php echo trans("slug_exp"); ?>)</small>
                        </label>
                        <input type="text" class="form-control" name="slug" placeholder="<?php echo trans("slug"); ?>" value="<?php echo html_escape($page->slug); ?>" <?php echo ($rtl == true) ? 'dir="rtl"' : ''; ?>>
                    </div>
                <?php else: ?>
                    <input type="hidden" name="slug" value="<?php echo html_escape($page->slug); ?>">
                <?php endif; ?>

                <div class="form-group">
                    <label class="control-label"><?php echo trans("description"); ?> (<?php echo trans('meta_tag'); ?>)</label>
                    <input type="text" class="form-control" name="page_description"
                           placeholder="<?php echo trans("description"); ?> (<?php echo trans('meta_tag'); ?>)"
                           value="<?php echo html_escape($page->page_description); ?>" <?php echo ($rtl == true) ? 'dir="rtl"' : ''; ?>>
                </div>

                <div class="form-group">
                    <label class="control-label"><?php echo trans('keywords'); ?> (<?php echo trans('meta_tag'); ?>)</label>
                    <input type="text" class="form-control" name="page_keywords"
                           placeholder="<?php echo trans('keywords'); ?> (<?php echo trans('meta_tag'); ?>)" value="<?php echo html_escape($page->page_keywords); ?>" <?php echo ($rtl == true) ? 'dir="rtl"' : ''; ?>>
                </div>

                <div class="form-group">
                    <label><?php echo trans("language"); ?></label>
                    <select name="lang_id" class="form-control" onchange="get_menu_links_by_lang(this.value);" style="max-width: 600px;">
                        <?php foreach ($languages as $language): ?>
                            <option value="<?php echo $language->id; ?>" <?php echo ($page->lang_id == $language->id) ? 'selected' : ''; ?>><?php echo $language->name; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <?php if ($page->location == "header"): ?>
                    <div class="form-group">
                        <label class="control-label"><?php echo trans('parent_link'); ?></label>
                        <select id="parent_links" name="parent_id" class="form-control" style="max-width: 600px;">
                            <option value="0"><?php echo trans('none'); ?></option>
                            <?php foreach ($menu_links as $item): ?>
                                <?php if ($item["type"] != "category" && $item["location"] == "header" && $item['parent_id'] == "0" && $item['id'] != $page->id): ?>
                                    <?php if ($item["id"] == $page->parent_id): ?>
                                        <option value="<?php echo $item["id"]; ?>"
                                                selected><?php echo $item["title"]; ?></option>
                                    <?php else: ?>
                                        <option value="<?php echo $item["id"]; ?>"><?php echo $item["title"]; ?></option>
                                    <?php endif; ?>
                                <?php endif; ?>
                            <?php endforeach; ?>

                        </select>
                    </div>
                <?php else: ?>
                    <input type="hidden" name="parent_id" value="<?php echo html_escape($page->parent_id); ?>">
                <?php endif; ?>
                
				<div class="form-group">
                <div class="row">
                    <div class="col-sm-3 col-xs-12">
                        <label><?php echo trans('subcategory'); ?></label>
                    </div>
               </div><div class="col-xm-12">
	 <div class="table-responsive">
		 <table class="table table-bordered table-striped" role="grid">
			<tbody>
				<tr>
				<?php $valuesub = ($page->subcat_recip_id);
				$array_of_values = explode(",", $valuesub); ?>
				<td>
				<?php foreach ($array_of_values as $item) :?>
				<input type="checkbox" name="subcat_recip_id[]" class="square-purple" value="<?php echo html_escape($item["title"]); ?>" <?=(in_array($subcat_recip_id,$item))?"CHECKED":""?>> &nbsp; <?=html_escape($item["title"]);?>
				<?php endforeach; ?>
				</td> 
				<?=html_escape($valuesub)?>
				</tr>
			 </tbody>
		 </table>
                     </div>   
                    </div>
                
            </div>
				
                <div class="form-group">
                    <label><?php echo trans('order'); ?></label>
                    <input type="number" class="form-control" name="page_order" placeholder="<?php echo trans('order'); ?>" value="<?php echo html_escape($page->page_order); ?>" min="1" style="width: 300px;max-width: 100%;" <?php echo ($rtl == true) ? 'dir="rtl"' : ''; ?>>
                </div>

                <?php if ($page->slug != "terms-conditions"): ?>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-3 col-xs-12">
                                <label><?php echo trans('location'); ?></label>
                            </div>
                            <div class="col-md-2 col-sm-4 col-xs-12 col-option">
                                <input type="radio" id="location_1" name="location" value="header" class="square-purple" <?php echo ($page->location == 'header') ? 'checked' : ''; ?>>
                                <label for="location_1" class="cursor-pointer"><?php echo trans('header'); ?></label>
                            </div>
                            <div class="col-md-2 col-sm-4 col-xs-12 col-option">
                                <input type="radio" id="location_2" name="location" value="footer" class="square-purple" <?php echo ($page->location == 'footer') ? 'checked' : ''; ?>>
                                <label for="location_2" class="cursor-pointer"><?php echo trans('footer'); ?></label>
                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <input type="hidden" name="location" value="<?php echo html_escape($page->location); ?>">
                <?php endif; ?>

                <?php if ($page->slug != "terms-conditions"): ?>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-3 col-xs-12">
                                <label><?php echo trans('visibility'); ?></label>
                            </div>
                            <div class="col-md-2 col-sm-4 col-xs-12 col-option">
                                <input type="radio" id="page_active_1" name="page_active" value="1" class="square-purple" <?php echo ($page->page_active == 1) ? 'checked' : ''; ?>>
                                <label for="page_active_1" class="cursor-pointer"><?php echo trans('show'); ?></label>
                            </div>
                            <div class="col-md-2 col-sm-4 col-xs-12 col-option">
                                <input type="radio" id="page_active_2" name="page_active" value="0" class="square-purple" <?php echo ($page->page_active == 0) ? 'checked' : ''; ?>>
                                <label for="page_active_2" class="cursor-pointer"><?php echo trans('hide'); ?></label>
                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <input type="hidden" name="page_active" value="<?php echo html_escape($page->page_active); ?>">
                <?php endif; ?>


                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-3 col-xs-12">
                            <label><?php echo trans('show_only_registered'); ?></label>
                        </div>
                        <div class="col-md-2 col-sm-4 col-xs-12 col-option">
                            <input type="radio" id="need_auth_1" name="need_auth" value="1" class="square-purple" <?php echo ($page->need_auth == 1) ? 'checked' : ''; ?>>
                            <label for="need_auth_1" class="cursor-pointer"><?php echo trans('yes'); ?></label>
                        </div>
                        <div class="col-md-2 col-sm-4 col-xs-12 col-option">
                            <input type="radio" id="need_auth_2" name="need_auth" value="0" class="square-purple" <?php echo ($page->need_auth == 0) ? 'checked' : ''; ?>>
                            <label for="need_auth_2" class="cursor-pointer"><?php echo trans('no'); ?></label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-3 col-xs-12">
                            <label><?php echo trans('show_title'); ?></label>
                        </div>
                        <div class="col-md-2 col-sm-4 col-xs-12 col-option">
                            <input type="radio" id="title_active_1" name="title_active" value="1" class="square-purple" <?php echo ($page->title_active == 1) ? 'checked' : ''; ?>>
                            <label for="title_active_1" class="cursor-pointer"><?php echo trans('yes'); ?></label>
                        </div>
                        <div class="col-md-2 col-sm-4 col-xs-12 col-option">
                            <input type="radio" id="title_active_2" name="title_active" value="0" class="square-purple" <?php echo ($page->title_active == 0) ? 'checked' : ''; ?>>
                            <label for="title_active_2" class="cursor-pointer"><?php echo trans('no'); ?></label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-3 col-xs-12">
                            <label><?php echo trans('show_breadcrumb'); ?></label>
                        </div>
                        <div class="col-md-2 col-sm-4 col-xs-12 col-option">
                            <input type="radio" id="breadcrumb_active_1" name="breadcrumb_active" value="1" class="square-purple" <?php echo ($page->breadcrumb_active == 1) ? 'checked' : ''; ?>>
                            <label for="breadcrumb_active_1" class="cursor-pointer"><?php echo trans('yes'); ?></label>
                        </div>
                        <div class="col-md-2 col-sm-4 col-xs-12 col-option">
                            <input type="radio" id="breadcrumb_active_2" name="breadcrumb_active" value="0" class="square-purple" <?php echo ($page->breadcrumb_active == 0) ? 'checked' : ''; ?>>
                            <label for="breadcrumb_active_2" class="cursor-pointer"><?php echo trans('no'); ?></label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-3 col-xs-12">
                            <label><?php echo trans('show_right_column'); ?></label>
                        </div>
                        <div class="col-md-2 col-sm-4 col-xs-12 col-option">
                            <input type="radio" id="right_column_active_1" name="right_column_active" value="1" class="square-purple" <?php echo ($page->right_column_active == 1) ? 'checked' : ''; ?>>
                            <label for="right_column_active_1" class="cursor-pointer"><?php echo trans('yes'); ?></label>
                        </div>
                        <div class="col-md-2 col-sm-4 col-xs-12 col-option">
                            <input type="radio" id="right_column_active_2" name="right_column_active" value="0" class="square-purple" <?php echo ($page->right_column_active == 0) ? 'checked' : ''; ?>>
                            <label for="right_column_active_2" class="cursor-pointer"><?php echo trans('no'); ?></label>
                        </div>
                    </div>
                </div>
				
				<?php if ($page->howmany_people >= 1 || $page->difficulty > "" || $page->howmany_time >= 1): ?>
				      <br /><div class="form-group">
                    <label><?php echo trans('howmany_people'); ?></label>
                    <input type="number" class="form-control" name="howmany_people" placeholder="<?php echo trans('howmany_people'); ?>" value="<?php echo html_escape($page->howmany_people); ?>" min="0" style="width: 100px;max-width: 100%;" <?php echo ($rtl == true) ? 'dir="rtl"' : ''; ?>>
                </div>

				<div class="form-group">
                    <div class="row">
                        <div class="col-sm-3 col-xs-12">
                            <label><?php echo trans('Difficulty'); ?></label>
                        </div>
                        <div class="col-md-2 col-sm-4 col-xs-12 col-option">
                            <input type="radio" id="difficulty_1" name="difficulty" value="Bassa" class="square-purple" <?php echo ($page->difficulty == 'Bassa') ? 'checked' : ''; ?>>
                            <label for="difficulty_1" class="cursor-pointer"><?php echo trans('difficultyL'); ?></label>
                        </div>
                        <div class="col-md-2 col-sm-4 col-xs-12 col-option">
                            <input type="radio" id="difficulty_2" name="difficulty" value="Media" class="square-purple" <?php echo ($page->difficulty == 'Media') ? 'checked' : ''; ?>>
                            <label for="difficulty_2" class="cursor-pointer"><?php echo trans('difficultyM'); ?></label>
                        </div>
						<div class="col-md-2 col-sm-4 col-xs-12 col-option">
                            <input type="radio" id="difficulty_3" name="difficulty" value="Alta" class="square-purple" <?php echo ($page->difficulty == 'Alta') ? 'checked' : ''; ?>>
                            <label for="difficulty_3" class="cursor-pointer"><?php echo trans('difficultyH'); ?></label>
                        </div>
                    </div>
                </div>
				<div class="form-group">
					<label><?php echo trans('howmany_time'); ?></label>
	<div class="row">
		<div class="col-sm-6 col-xs-12">
                    <input type="number" class="form-control" name="howmany_time" placeholder="<?php echo trans('howmany_time'); ?>" value="<?php echo html_escape($page->howmany_time); ?>" min="1" style="display: inline-block; width: 100px; max-width: 100%;" <?php echo ($rtl == true) ? 'dir="rtl"' : ''; ?>>
					<label><?php echo trans('howmany_min'); ?></label>
                </div>
					</div></div>
				<?php endif; ?>
                <?php if ($page->slug != "gallery" && $page->slug != "contact"): ?>
                    <div class="form-group" style="margin-top: 60px;">
                        <label><?php echo trans('content'); ?></label>
                        <textarea id="ckEditor" class="form-control" name="page_content"
                                  placeholder="<?php echo trans('content'); ?>"><?php echo $page->page_content; ?></textarea>
                    </div>
                <?php endif; ?>

            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <button type="submit" class="btn btn-primary pull-right"><?php echo trans('save_changes'); ?></button>
            </div>
            <!-- /.box-footer -->

            <?php echo form_close(); ?><!-- form end -->
        </div>
        <!-- /.box -->
    </div>
</div>

<?php $this->load->view("admin/includes/_file_manager_ckeditor"); ?>
