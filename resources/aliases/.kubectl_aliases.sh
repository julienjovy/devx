# Basic aliases
alias k='kubectl'
alias kgp='kubectl get pods'
alias kgd='kubectl get deployments'
alias kgs='kubectl get services'
alias kgn='kubectl get nodes'
alias kctx='kubectl config current-context'
alias kns='kubectl config set-context --current --namespace'

# Display
alias kgpa='kubectl get pods --all-namespaces'
alias kgpl='kubectl get pods -o wide'

# Logs
alias kl='kubectl logs'
alias klf='kubectl logs -f'

# Describe pod, deployment, service
alias kdpo='kubectl describe pod'
alias kddep='kubectl describe deployment'
alias kdsvc='kubectl describe service'

# Delete pod, deployment, service
alias krpo='kubectl delete pod'
alias krdep='kubectl delete deployment'
alias krsvc='kubectl delete service'

# Apply configuration from yaml/json file
alias kap='kubectl apply -f'

# Execute a shell in a pod
alias ksh='kubectl exec -it -- /bin/sh'
alias kbash='kubectl exec -it -- /bin/bash'

# Rollout status and history
alias kro='kubectl rollout status deployment'
alias krh='kubectl rollout history deployment'

# Scale a deployment
alias kscale='kubectl scale deployment'

# Port-forwarding
alias kpf='kubectl port-forward'

# Patch a resource
alias kpatch='kubectl patch'

# Clean finished or crashed pods
alias kclean='kubectl get pods --field-selector=status.phase=Succeeded -o name | xargs kubectl delete'

# Quick switch between namespaces
alias knsdev='kubectl config set-context --current --namespace=development'
alias knsprod='kubectl config set-context --current --namespace=production'

# Show cluster resources
alias klr='kubectl get all --all-namespaces'

# Shortcut to get custom resources (CRD)
alias kgcrd='kubectl get crd'
