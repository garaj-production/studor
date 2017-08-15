<?php

namespace Deployer;

require 'recipe/symfony3.php';
require 'vendor/deployphp/recipes/rsync.php';

// Configuration

set('repository', 'https://github.com/ahatojli4/studor.git');
set('git_tty', true);
set('ssh_type', 'native');
set('ssh_multiplexing', true);
set('keep_releases', 2);
set('default_stage', 'demo');

add('shared_files', []);
add('shared_dirs', []);
add('writable_dirs', []);

// static start
set('rsync',[
    'exclude'      => [],
    'exclude-file' => false,
    'include'      => [],
    'include-file' => false,
    'filter'       => [],
    'filter-file'  => false,
    'filter-perdir'=> false,
    'flags'        => 'rz', // Recursive, with compress
    'options'      => ['delete'],
    'timeout'      => 60,
]);

set('clear_paths', ['web/assets/']);
set('rsync_src', __DIR__ . '/web/assets/');
set('rsync_dest','{{release_path}}/web/assets/');

task('build_static', function() {
    runLocally('webpack');
});
// static end

// Hosts
server('demo', 'green.elastictech.org')
    ->user('u3087')
    ->set('env', 'prod')
    ->set('http_user', 'u3087')
    ->set('deploy_path', '/home/u3087/domains/u3087.green.elastictech.org');

// Tasks
before('rsync', 'build_static');
after('deploy:clear_paths', 'rsync');

after('deploy:failed', 'deploy:unlock');
before('deploy:symlink', 'database:migrate');
