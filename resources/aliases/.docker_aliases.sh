# Gestion des containers
alias dps='docker ps'
alias dpsa='docker ps -a'
alias dim='docker images'
alias drm='docker rm'       # supprimer un ou plusieurs containers
alias drmi='docker rmi'     # supprimer une ou plusieurs images

# Démarrer / arrêter / redémarrer
alias dstart='docker start'
alias dstop='docker stop'
alias drestart='docker restart'

# Logs et shell dans un container
alias dlogs='docker logs -f'
alias dexec='docker exec -it'  # ex: dexec <container> /bin/bash

# Construire et lancer
alias dbuild='docker build -t'
alias dup='docker-compose up -d'
alias ddown='docker-compose down'

# Statistiques et info
alias dstats='docker stats'
alias dinspect='docker inspect'

# Nettoyer
alias dclean='docker system prune -f'
alias dcleanvolumes='docker volume prune -f'

# Docker compose (si installé)
alias dcs='docker-compose'

