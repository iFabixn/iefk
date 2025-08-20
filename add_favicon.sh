#!/bin/bash
# 🔖 Script para agregar favicon a todas las páginas IEFK

echo "🔖 Agregando favicon a todas las páginas..."

# Función para agregar favicon
add_favicon() {
    local file="$1"
    local path_to_assets="$2"
    
    # Verificar si ya tiene favicon
    if grep -q "favicon\|icon.*png" "$file"; then
        echo "✅ $file ya tiene favicon"
        return
    fi
    
    # Buscar la línea del title y agregar favicon después
    if grep -q "<title>" "$file"; then
        # Crear archivo temporal
        temp_file=$(mktemp)
        
        # Procesar línea por línea
        while IFS= read -r line; do
            echo "$line" >> "$temp_file"
            if [[ $line == *"<title>"* ]]; then
                echo "" >> "$temp_file"
                echo "    <!-- 🔖 Favicon -->" >> "$temp_file"
                echo "    <link rel=\"icon\" type=\"image/png\" href=\"${path_to_assets}assets/img/logo sin letras.png\">" >> "$temp_file"
                echo "    <link rel=\"shortcut icon\" type=\"image/png\" href=\"${path_to_assets}assets/img/logo sin letras.png\">" >> "$temp_file"
                echo "    <link rel=\"apple-touch-icon\" href=\"${path_to_assets}assets/img/logo sin letras.png\">" >> "$temp_file"
            fi
        done < "$file"
        
        # Reemplazar archivo original
        mv "$temp_file" "$file"
        echo "🔖 Favicon agregado a $file"
    else
        echo "⚠️  No se encontró <title> en $file"
    fi
}

# Agregar favicon a archivos del directorio principal
for file in /Applications/XAMPP/xamppfiles/htdocs/iefk/*.php; do
    if [[ -f "$file" && "$file" != *"/db.php" ]]; then
        add_favicon "$file" ""
    fi
done

# Agregar favicon a archivos del admin (con ruta relativa)
for file in /Applications/XAMPP/xamppfiles/htdocs/iefk/admin/*.php; do
    if [[ -f "$file" ]]; then
        add_favicon "$file" "../"
    fi
done

echo "✅ ¡Favicon agregado a todas las páginas!"
echo "🎨 Logo: /assets/img/logo sin letras.png"
