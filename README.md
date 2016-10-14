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

## Clone repository
```bash
git clone git://10.0.106.114/magento2-hackathon
cd magento2-hackathon
```

## Install dependencies
```bash
npm install
```

## Pull magento2 docker image

Add ```10.0.106.114:5000``` to insecure registries in advanced settings.

```bash
docker pull 10.0.106.114:5000/magento2-hackathon:latest
```

## Prepare docker container
```bash
sudo ifconfig lo0 alias 127.0.0.5
export DOCKER_CONTAINER_NAME='magento2-hackathon'
docker create --name ${DOCKER_CONTAINER_NAME} -p 127.0.0.5:80:80 10.0.106.114:5000/magento2-hackathon:latest
docker start ${DOCKER_CONTAINER_NAME}
```

## Prepare magento2
```bash
bin/magento setup:store-config:set --base-url='http://127.0.0.5/'
bin/magento cache:flush
docker cp ${DOCKER_CONTAINER_NAME}:/var/www/dist ./
gulp deploy:docker
docker exec ${DOCKER_CONTAINER_NAME} chmod +x /var/www/dist/bin/magento
bin/magento module:status
bin/magento module:enable TechDivision_Hello
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
http://127.0.0.5/admin

Username: admin

Password: password1
