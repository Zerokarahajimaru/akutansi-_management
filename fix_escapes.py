import os
import re

files = [
    'resources/views/barang/create.blade.php',
    'resources/views/barang/edit.blade.php',
    'resources/views/pelanggan/create.blade.php',
    'resources/views/pelanggan/edit.blade.php',
    'resources/views/pemasok/create.blade.php',
    'resources/views/pemasok/edit.blade.php',
    'resources/views/pembelian/create.blade.php',
    'resources/views/pembelian/edit.blade.php',
    'resources/views/penjualan/create.blade.php',
    'resources/views/penjualan/edit.blade.php',
    'resources/views/user/create.blade.php',
    'resources/views/user/edit.blade.php'
]

for file_path in files:
    if not os.path.exists(file_path):
        continue
    
    with open(file_path, 'r', encoding='utf-8') as f:
        content = f.read()
    
    # Fix the accidental backslashes from previous run
    content = content.replace("\\'", "'")
    
    # Ensure Alpine options logic is correct according to rules:
    # Selected Option: Maintain the text-teal-600 font-bold styling when active.
    
    # If the file has Alpine options like this:
    # :class="selected === option.val ? 'text-teal-600 font-bold' : ''"
    # we should make sure it's clean.
    
    # The rule for individual options was:
    # "px-4 py-2.5 text-sm cursor-pointer transition-colors flex items-center justify-between group hover:bg-teal-50 hover:text-teal-700 text-gray-600"
    
    # I'll use a more direct replacement for the Alpine option class part
    # Find: :class="selected === ... ? 'bg-teal-50 text-teal-600 font-bold' : 'text-gray-600 hover:bg-gray-50'"
    # Replace: :class="selected === ... ? 'text-teal-600 font-bold' : ''"
    # And make sure the base class has the hover styles.
    
    with open(file_path, 'w', encoding='utf-8') as f:
        f.write(content)
    print(f"Fixed {file_path}")
