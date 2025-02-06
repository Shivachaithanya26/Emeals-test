pipeline {
    agent any

    environment {
        DEPLOY_DIR = "/var/www/html"
        REPO_URL = "https://github.com/Shivachaithanya26/Emeals-test.git"
        VERSION_FILE = "/var/deployment-version.txt"
    }

    stages {
        stage('Checkout Release Tag') {
            steps {
                script {
                    // Clean the workspace directory before cloning the repository
                    sh "rm -rf workspace"
                    // Fetch all tags first to ensure we can access them
                    sh "git fetch --tags"
                    // Get the most recent tag from the repository
                    def releaseTag = sh(script: 'git describe --tags --abbrev=0', returnStdout: true).trim()
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
            script {
                // Get the deployed tag to write it to the version file
                def releaseTag = sh(script: 'git describe --tags --abbrev=0', returnStdout: true).trim()
                // Use sudo to write the tag to the version file
                sh "echo '${releaseTag}' | sudo tee $VERSION_FILE > /dev/null"
                echo "Deployed tag written to ${VERSION_FILE}"
            }
        }
        failure {
            echo "Deployment failed! Version file remains unchanged."
        }
    }
}
