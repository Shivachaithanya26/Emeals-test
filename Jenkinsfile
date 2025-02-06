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
                    // Clean the workspace directory before cloning the repository
                    sh "rm -rf workspace"
                    // Fetch all tags first to ensure we can access them
                    sh "git fetch --tags"
                    // Use the specific tag you want to checkout
                    def releaseTag = "v1.0.4"  // Directly specify your release tag
                    echo "Checking out release tag: ${releaseTag}"
                    // Now clone the repository using the release tag
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
