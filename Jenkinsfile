pipeline {
    agent any

    environment {
        DEPLOY_DIR = "/var/www/html"
        REPO_URL = "https://github.com/Shivachaithanya26/Emeals-test.git"
    }

    stages {
        stage('Clone Repository') {
            steps {
                script {
                    sh "rm -rf workspace && git clone $REPO_URL workspace"
                }
            }
        }

        stage('Debug Jenkins User') {
            steps {
                script {
                    sh 'whoami'
                    sh 'sudo -l'
                }
            }
        }
        
        stage('Deploy to Server') {
            steps {
                script {
                    sh """
                        rm -rf $DEPLOY_DIR/*
                        cp -r workspace/* $DEPLOY_DIR/
                    """
                }
            }
        }

        stage('Restart Nginx') {
            steps {
                script {
                    sh "sudo systemctl restart nginx"
                }
            }
        }
    }

    post {
        success {
            echo "Deployment successful!"
        }
        failure {
            echo "Deployment failed!"
        }
    }
}
