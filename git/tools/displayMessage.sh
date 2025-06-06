#!/bin/bash

get_display_width() {
    local input="$1"
    python3 -c "import sys; import unicodedata; print(sum(2 if unicodedata.east_asian_width(c) in 'WF' else 1 for c in sys.argv[1]))" "$input"
}

# Entrée
message="$1"

# Paramètres ajustables
marge=4            # Nombre d'espaces de chaque côté du texte
max_line_length=50 # Limite de caractères par ligne avant retour à la ligne

# Fonction pour couper le texte en lignes de max_line_length
wrap_lines() {
    local text="$1"
    local limit=$2
    echo "$text" | fold -s -w $limit
}

# On découpe le message
lines=()
while IFS= read -r line; do
    lines+=("$line")
done < <(wrap_lines "$message" "$max_line_length")

# Trouver la longueur maximale des lignes
max_length=0
for line in "${lines[@]}"; do
    line_length=$(get_display_width "$line")
    [ $line_length -gt $max_length ] && max_length=$line_length
done


# Largeur totale du cadre
box_width=$((max_length + 2 * marge))

# Bords supérieur et inférieur
top="╔$(printf '═%.0s' $(seq 1 $box_width))╗"
bottom="╚$(printf '═%.0s' $(seq 1 $box_width))╝"

# Affichage
echo -e "\033[1;33m$top\033[0m"
for line in "${lines[@]}"; do
    line_length=$(get_display_width "$line")
    padding=$((box_width - line_length))
    left_space=$(printf ' %.0s' $(seq 1 $((padding / 2))))
    right_space=$(printf ' %.0s' $(seq 1 $((padding - (padding / 2)))))
    echo -e "\033[1;33m║\033[0m\033[1;32m$left_space$line$right_space\033[0m\033[1;33m║\033[0m"
done
echo -e "\033[1;33m$bottom\033[0m"
