# Magento2 Hackathon

## Prerequisites

You need to have current versions of docker, node, npm, gulp-cli and php composer installed

```bash
/usr/bin/ruby -e "$(curl -fsSL https://raw.githubusercontent.com/Homebrew/install/master/install)"
brew tap caskroom/cask
brew tap homebrew/services
brew cask install docker
brew install node
brew install php70 php70-mcrypt php70-intl
npm install -g gulp-cli
curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
```

## Pull magento2-ee repository
```bash
docker pull 10.0.106.144/magento2-hackaton:latest
```

## Prepare docker container
```bash
sudo ifconfig lo0 alias 127.0.0.5
DOCKER_CONTAINER_NAME='magento2-hackathon'
docker create --name ${DOCKER_CONTAINER_NAME} -p 127.0.0.5:80:80 registry.ci.magento2.tdintern.de/magento2-ee:latest
docker start ${DOCKER_CONTAINER_NAME}
```

## Prepare magento2
```bash
bin/magento setup:store-config:set --base-url='http://127.0.0.5/'
bin/magento cache:flush
docker cp magento2-hackathon:/var/www/dist ./
gulp deploy:docker
bin/magento module:status
bin/magento module:enable TechDivision_PageDesigner
bin/magento setup:upgrade
bin/magento setup:static-content:deploy
bin/magento deploy:mode:set developer
bin/magento cache:flush
```

## Start development watcher
```bash
gulp dev:docker
```

## Magento Backend
Username: admin
Password: password1