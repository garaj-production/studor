<?php
namespace Deployer;

require 'recipe/symfony3.php';

// Configuration

set('repository', 'git@github.com:ahatojli4/studor.git');
set('git_tty', true); // [Optional] Allocate tty for git on first deployment
set('keep_releases', 2);
set('default_stage', 'demo');

add('shared_files', []);
add('shared_dirs', []);
add('writable_dirs', []);

// Hosts
host('green.elastictech.org')
    ->user('u3087')
    ->stage('demo')
    ->set('env', 'prod')
    ->set('http_user', 'u3087')
    ->set('deploy_path', '/home/u3087/domains/u3087.green.elastictech.org');

// Tasks

// [Optional] if deploy fails automatically unlock.
after('deploy:failed', 'deploy:unlock');

// Migrate database before symlink new release.

before('deploy:symlink', 'database:migrate');
