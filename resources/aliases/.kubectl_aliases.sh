# Alias de base
alias k='kubectl'
alias kgp='kubectl get pods'
alias kgd='kubectl get deployments'
alias kgs='kubectl get services'
alias kgn='kubectl get nodes'
alias kctx='kubectl config current-context'
alias kns='kubectl config set-context --current --namespace'


# Affichage
alias kgpa='kubectl get pods --all-namespaces'
alias kgpl='kubectl get pods -o wide'

# Logs
alias kl='kubectl logs'
alias klf='kubectl logs -f'

# Décrire un pod, deployment, service
alias kdpo='kubectl describe pod'
alias kddep='kubectl describe deployment'
alias kdsvc='kubectl describe service'

# Supprimer un pod, deployment, service
alias krpo='kubectl delete pod'
alias krdep='kubectl delete deployment'
alias krsvc='kubectl delete service'

# Appliquer la configuration d’un fichier yaml/json
alias kap='kubectl apply -f'

# Exécuter un shell dans un pod
alias ksh='kubectl exec -it -- /bin/sh'
alias kbash='kubectl exec -it -- /bin/bash'


# Rollout status et history
alias kro='kubectl rollout status deployment'
alias krh='kubectl rollout history deployment'

# Scale un deployment
alias kscale='kubectl scale deployment'

# Port-forwarding
alias kpf='kubectl port-forward'

# Patch un ressource
alias kpatch='kubectl patch'

# Nettoyer les pods terminés ou crashés
alias kclean='kubectl get pods --field-selector=status.phase=Succeeded -o name | xargs kubectl delete'

# Passage rapide entre namespaces
alias knsdev='kubectl config set-context --current --namespace=development'
alias knsprod='kubectl config set-context --current --namespace=production'

# Afficher les ressources du cluster
alias klr='kubectl get all --all-namespaces'

# Raccourci pour obtenir les ressources custom (CRD)
alias kgcrd='kubectl get crd'

