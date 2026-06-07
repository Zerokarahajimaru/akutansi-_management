import os
import re

def refactor_blade(content):
    # 1. First, protect already correct strings or special cases if any
    
    # 2. General replacements
    content = content.replace('bg-white', 'bg-[#CD9D37]')
    content = content.replace('bg-slate-50', 'bg-[#CD9D37]')
    content = content.replace('bg-teal-50', 'bg-[#CD9D37]')
    content = content.replace('bg-slate-100', 'bg-[#525925]/10')
    
    content = content.replace('text-slate-800', 'text-[#525925]')
    content = content.replace('text-slate-900', 'text-[#000000]')
    content = content.replace('text-slate-700', 'text-[#525925]/90')
    content = content.replace('text-slate-600', 'text-[#525925]/90')
    content = content.replace('text-slate-500', 'text-[#525925]/80')
    content = content.replace('text-slate-400', 'text-[#525925]/60')
    content = content.replace('text-slate-300', 'text-[#525925]/40')
    
    content = content.replace('border-slate-100', 'border-[#525925]/30')
    content = content.replace('border-slate-50', 'border-[#525925]/20')
    content = content.replace('border-slate-200', 'border-[#525925]/30')
    content = content.replace('border-slate-300', 'border-[#525925]/40')
    content = content.replace('border-slate-400', 'border-[#525925]/50')
    
    content = content.replace('divide-slate-50', 'divide-[#525925]/10')
    content = content.replace('divide-slate-100', 'divide-[#525925]/20')
    
    content = content.replace('hover:bg-slate-50', 'hover:bg-[#525925]/10')
    content = content.replace('hover:bg-slate-100', 'hover:bg-[#525925]/20')

    # 3. Table Headers (Improved to skip PHP blocks)
    # Target <tr> inside <thead>. We'll find <thead> and then the first <tr class="..."> after it.
    def replace_header_tr(match):
        thead_content = match.group(0)
        # Find the first tr tag and replace its class
        thead_content = re.sub(r'<tr class="[^"]*"', r'<tr class="bg-[#525925] text-white text-[10px] font-black uppercase tracking-widest whitespace-nowrap"', thead_content)
        # Also remove any border-b-2 or other header-specific classes that might be outside the class attribute if any (unlikely in Tailwind)
        return thead_content

    content = re.sub(r'<thead>.*?</tr>', replace_header_tr, content, flags=re.DOTALL)

    # 4. Fix Inputs (Restore white background)
    # Avoid double /90/90
    content = content.replace('bg-white/90/90', 'bg-white/90')
    content = re.sub(r'(<(input|textarea|select)[^>]*class="[^"]*)bg-\[#CD9D37\]', r'\1bg-white/90', content)
    
    # 5. Surgical cleanup for table headers that might have missed the head block but match the old gold header pattern
    content = re.sub(r'<tr class="[^"]*bg-\[#CD9D37\][^"]*text-\[#525925\][^"]*border-b-2 border-\[#8E734B\][^"]*">',
                     r'<tr class="bg-[#525925] text-white text-[10px] font-black uppercase tracking-widest whitespace-nowrap">', content)

    # 6. Final cleanup of double /90
    content = content.replace('bg-white/90/90', 'bg-white/90')

    return content

def process_directory(directory):
    for root, dirs, files in os.walk(directory):
        for file in files:
            if file.endswith('.blade.php'):
                path = os.path.join(root, file)
                with open(path, 'r', encoding='utf-8') as f:
                    content = f.read()
                
                new_content = refactor_blade(content)
                
                if new_content != content:
                    with open(path, 'w', encoding='utf-8') as f:
                        f.write(new_content)
                    print(f"Refactored: {path}")

if __name__ == "__main__":
    process_directory('resources/views')
