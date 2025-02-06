pipeline {
    agent any

    environment {
        DEPLOY_DIR = "/var/www/html"
        REPO_URL = "https://github.com/Shivachaithanya26/Emeals-test.git"
    }

    stages {
        stage('Checkout Release Tag') {
            steps {
                script {
                    // Get the release tag
                    def releaseTag = sh(script: 'git describe --tags', returnStdout: true).trim()
                    // Clone the repository with the specific tag
                    sh "git clone --branch $releaseTag --single-branch $REPO_URL workspace"
                }
            }
        }

        stage('Deploy to Server') {
            steps {
                script {
                    // Clean and copy new files to the deploy directory
                    sh "rm -rf $DEPLOY_DIR/*"
                    sh "cp -r workspace/* $DEPLOY_DIR/"
                }
            }
        }

        stage('Restart Nginx') {
            steps {
                script {
                    // Restart Nginx to apply changes
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
