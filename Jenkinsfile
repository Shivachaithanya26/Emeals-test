pipeline {
    agent any

    environment {
        DEPLOY_DIR = "/var/www/html"
        REPO_URL = "https://github.com/Shivachaithanya26/Emeals-test.git"
    }

    stage('Checkout Release Tag') {
    steps {
        script {
            // Clean the workspace directory before cloning the repository
            sh "rm -rf workspace"
            // Now clone the repository using the release tag
            def releaseTag = sh(script: 'git describe --tags', returnStdout: true).trim()
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
