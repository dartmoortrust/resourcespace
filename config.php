<?php
###############################
## ResourceSpace
## Local Configuration Script
###############################

# All custom settings should be entered in this file.
# Options may be copied from config.default.php and configured here.

# MySQL database settings
$mysql_server = 'mariadb';
$mysql_username = 'resourcespace_rw';
$mysql_password = 'change-me';
$mysql_db = 'resourcespace';

# Base URL of the installation
$baseurl = 'http://blackbox:8010';

# Email settings
$email_notify = 'jamie@dunbar.me';
$email_from = 'jamie@dunbar.me';
# Secure keys
$scramble_key = '5801d832b8e16815487cb62b231ebbeb764878b107690c28f0a071cf2e32a3db';
$api_scramble_key = '0803381815c7b028e5169f5344c896bab17d64325b37091ea2ed7fcbd7497ebd';

# Paths
$imagemagick_path = '/usr/bin';
$ghostscript_path = '/usr/bin';
$ffmpeg_path = '/usr/bin';
$exiftool_path = '/usr/bin';
$pdftotext_path = '/usr/bin';

$applicationname = 'ResourceSpace';
$homeanim_folder = 'filestore/system/slideshow_ead7ddb39d4e961';

$get_temp_dir = '/tmp/resourcespace';

/*

New Installation Defaults
-------------------------

The following configuration options are set for new installations only.
This provides a mechanism for enabling new features for new installations without affecting existing installations (as would occur with changes to config.default.php)

*/
                                
// Set imagemagick default for new installs to expect the newer version with the sRGB bug fixed.
$imagemagick_colorspace = "sRGB";

$contact_link=false;

$stemming=true;
$case_insensitive_username=true;
$user_pref_user_management_notifications=true;

$use_zip_extension=true;
$collection_download=true;

$ffmpeg_preview_force = true;
$ffmpeg_preview_extension = 'mp4';
$ffmpeg_preview_options = '-f mp4 -b:v 1200k -b:a 64k -ac 1 -c:v libx264 -pix_fmt yuv420p -profile:v baseline -level 3 -c:a aac -strict -2';

$daterange_search = true;
$upload_then_edit = true;

$purge_temp_folder_age=90;

$comments_resource_enable=true;

$api_upload_urls = array();

$use_native_input_for_date_field = true;
$resource_view_use_pre = true;

$sort_tabs = false;
$maxyear_extends_current = 5;
$thumbs_display_archive_state = true;
$file_checksums = true;
$hide_real_filepath = true;
$annotate_enabled = true;
$filestore_evenspread = true;
$plugins[] = "brand_guidelines";
$plugins[] = 'custom_sha1_config_hook';
$originals_separate_storage = true;
$file_upload_block_duplicates = true;
$debug_log = true;
$debug_log_location = "/var/www/html/filestore/debug.txt";
$offline_job_queue = true;
$search_all_includes_urls = true;
// Standard Leaflet / Map defaults




function HookCustom_sha1_config_hookAllUploadfilesuccess($resource_ref)
{
    $resource = get_resource_data($resource_ref);
    if (!is_array($resource) || trim((string)$resource['file_extension']) === '') {
        return false;
    }
    $filepath = get_resource_path($resource_ref, true, '', false, $resource['file_extension']);
    if (file_exists($filepath)) {
        update_field($resource_ref, 88, sha1_file($filepath));
        debug("sha1 hook fired for resource {$resource_ref}");
    }
    return true;
}
