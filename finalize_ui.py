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

primary_button_new = 'class="px-10 py-3 bg-teal-600 text-white font-bold rounded-xl shadow-sm hover:bg-teal-700 hover:shadow-md hover:-translate-y-0.5 transition-all duration-300"'

for file_path in files:
    if not os.path.exists(file_path):
        continue
    
    with open(file_path, 'r', encoding='utf-8') as f:
        content = f.read()
    
    # 1. Update any submit button classes
    def sub_button(match):
        start = match.group(1)
        end = match.group(2)
        return f'{start}{primary_button_new}{end}'

    content = re.sub(r'(<button[^>]*type="submit"[^>]*)\bclass="[^"]*"(.*?>)', sub_button, content)
    content = re.sub(r'(<button[^>]*)\bclass="[^"]*"(.*?type="submit".*?>)', sub_button, content)

    # 2. Update Batal/Cancel links (Secondary Buttons)
    secondary_button_new = 'class="px-6 py-3 bg-gray-100 text-gray-600 font-semibold rounded-xl hover:bg-gray-200 transition-colors"'
    def sub_secondary(match):
        start = match.group(1)
        end = match.group(2)
        return f'{start}{secondary_button_new}{end}'
    
    content = re.sub(r'(<a[^>]*)\bclass="[^"]*"(.*?>\s*Batal\s*</a>)', sub_secondary, content)
    
    # 3. Ensure all inputs have the correct teal ring and hover
    content = re.sub(r'focus:ring-teal-500/20', 'focus:ring-teal-500/30', content)

    with open(file_path, 'w', encoding='utf-8') as f:
        f.write(content)
    print(f"Finalized {file_path}")
