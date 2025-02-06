pipeline {
    agent any

    environment {
        GIT_REPO = 'https://github.com/Shivachaithanya26/Emeals-test.git'
        DEPLOY_DIR = '/home/ubuntu/var/www/html'
    }

    stages {
        stage('Checkout Code') {
            steps {
                git branch: 'master', url: GIT_REPO
            }
        }

        stage('Deploy Code') {
            steps {
                sh """
                    rm -rf ${DEPLOY_DIR}/*
                    cp -r . ${DEPLOY_DIR}/
                    sudo chown -R www-data:www-data ${DEPLOY_DIR}
                """
            }
        }

        stage('Restart Web Server') {
            steps {
                sh "sudo systemctl restart nginx"
            }
        }
    }
}
