# Container management
alias dps='docker ps'
alias dpsa='docker ps -a'
alias dim='docker images'
alias drm='docker rm'
alias drmi='docker rmi'

# Start / stop / restart
alias dstart='docker start'
alias dstop='docker stop'
alias drestart='docker restart'

# Logs and shell in a container
alias dlogs='docker logs -f'
alias dexec='docker exec -it'

# Build and run
alias dbuild='docker build -t'
alias dup='docker-compose up -d'
alias ddown='docker-compose down'

# Stats and info
alias dstats='docker stats'
alias dinspect='docker inspect'

# Cleanup
alias dclean='docker system prune -f'
alias dcleanvolumes='docker volume prune -f'

# Docker Compose (if installed)
alias dcs='docker-compose'
