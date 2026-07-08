<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Disable foreign key checks to truncate tables
        \Illuminate\Support\Facades\Schema::disableForeignKeyConstraints();
        
        \App\Models\ProductImage::truncate();
        \App\Models\Product::truncate();
        \App\Models\Category::truncate();
        \App\Models\User::truncate();
        \App\Models\Company::truncate();

        \Illuminate\Support\Facades\Schema::enableForeignKeyConstraints();

        // 1. Create Company
        $company = \App\Models\Company::create([
            'name' => 'Nimbus Store',
            'slug' => 'nimbus-store',
            'tagline' => 'Sua loja de tecnologia e estilo de vida premium',
            'whatsapp' => '5511999999999',
            'pix_key' => 'contato@nimbus.com',
            'email' => 'contato@nimbus.com',
            'address' => 'Av. Paulista, 1000 - Bela Vista, São Paulo - SP',
            'instagram' => 'nimbus.store',
            'facebook' => 'nimbus.store',
        ]);

        // 2. Create User
        \App\Models\User::create([
            'name' => 'Superadmin',
            'email' => 'admin@nimbus.com',
            'password' => bcrypt('password'),
            'company_id' => $company->id,
            'role' => 'admin',
        ]);

        // 3. Define and Create Categories
        $categoriesData = [
            [
                'name' => 'Smartphones & Acessórios',
                'slug' => 'smartphones-e-acessorios',
                'icon' => 'Smartphone',
                'products' => [
                    [
                        'name' => 'iPhone 15 Pro Max (256GB) - Titânio Natural',
                        'slug' => 'iphone-15-pro-max-256gb-titanio-natural',
                        'description' => 'O primeiro iPhone com design de titânio aeroespacial, chip A17 Pro totalmente novo, sistema de câmera de zoom óptico de 5x mais potente e botão de Ação personalizável.',
                        'price' => 8599.99,
                        'old_price' => 9499.99,
                        'stock' => 12,
                        'badges' => ['Destaque', 'Frete Grátis'],
                        'images' => [
                            'https://images.unsplash.com/photo-1695048133142-1a20484d2569?auto=format&fit=crop&q=80&w=800',
                            'https://images.unsplash.com/photo-1695048133044-89304b7f940a?auto=format&fit=crop&q=80&w=800'
                        ]
                    ],
                    [
                        'name' => 'Samsung Galaxy S24 Ultra (512GB) - Titânio Cinza',
                        'slug' => 'samsung-galaxy-s24-ultra-512gb-titanio-cinza',
                        'description' => 'O smartphone definitivo com Galaxy AI. Tradução simultânea de chamadas, câmera de 200MP com zoom óptico de 10x, tela Dynamic AMOLED 2X brilhante de 6.8" e S Pen inclusa.',
                        'price' => 7299.00,
                        'old_price' => 7999.00,
                        'stock' => 8,
                        'badges' => ['Mais Vendido'],
                        'images' => [
                            'https://images.unsplash.com/photo-1610945265064-0e34e5519bbf?auto=format&fit=crop&q=80&w=800'
                        ]
                    ],
                    [
                        'name' => 'Carregador Magnético Sem Fio 15W',
                        'slug' => 'carregador-magnetico-sem-fio-15w',
                        'description' => 'Carregador sem fio por indução com alinhamento magnético perfeito para carregamento rápido e seguro do seu smartphone.',
                        'price' => 199.90,
                        'old_price' => 249.90,
                        'stock' => 45,
                        'badges' => [],
                        'images' => [
                            'https://images.unsplash.com/photo-1622445262465-2481c4574875?auto=format&fit=crop&q=80&w=800'
                        ]
                    ]
                ]
            ],
            [
                'name' => 'Áudio & Som',
                'slug' => 'audio-e-som',
                'icon' => 'Headphones',
                'products' => [
                    [
                        'name' => 'Headphone Bluetooth Sony WH-1000XM5',
                        'slug' => 'headphone-bluetooth-sony-wh-1000xm5',
                        'description' => 'O melhor cancelamento de ruído do mercado. Até 30 horas de autonomia de bateria, áudio de alta resolução sem fio, microfones com redução de ruído para chamadas cristalinas e design ultra confortável.',
                        'price' => 2199.00,
                        'old_price' => 2499.00,
                        'stock' => 15,
                        'badges' => ['Destaque', 'Premium'],
                        'images' => [
                            'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?auto=format&fit=crop&q=80&w=800',
                            'https://images.unsplash.com/photo-1546435770-a3e426bf472b?auto=format&fit=crop&q=80&w=800'
                        ]
                    ],
                    [
                        'name' => 'Apple AirPods Pro (2ª Geração) USB-C',
                        'slug' => 'apple-airpods-pro-2-geracao-usb-c',
                        'description' => 'Cancelamento Ativo de Ruído até duas vezes mais potente, modo Transparência Adaptativa, Áudio Espacial Personalizado com rastreamento dinâmico da cabeça e estojo de recarga MagSafe com alto-falante.',
                        'price' => 1899.00,
                        'old_price' => 2199.00,
                        'stock' => 20,
                        'badges' => ['Mais Vendido'],
                        'images' => [
                            'https://images.unsplash.com/photo-1600294037681-c80b4cb5b434?auto=format&fit=crop&q=80&w=800'
                        ]
                    ],
                    [
                        'name' => 'Caixa de Som Portátil JBL Flip 6',
                        'slug' => 'caixa-de-som-portatil-jbl-flip-6',
                        'description' => 'Som potente e graves profundos. Classificação IP67 à prova d\'água e poeira, bateria com duração de até 12 horas de reprodução contínua e recurso PartyBoost.',
                        'price' => 649.00,
                        'old_price' => 799.00,
                        'stock' => 30,
                        'badges' => ['Oferta'],
                        'images' => [
                            'https://images.unsplash.com/photo-1608043152269-423dbba4e7e1?auto=format&fit=crop&q=80&w=800'
                        ]
                    ]
                ]
            ],
            [
                'name' => 'Dispositivos Smart',
                'slug' => 'dispositivos-smart',
                'icon' => 'Tv',
                'products' => [
                    [
                        'name' => 'Smartwatch Apple Watch Series 9 GPS 45mm',
                        'slug' => 'smartwatch-apple-watch-series-9-gps-45mm',
                        'description' => 'Chip S9 superpotente, tela Retina Sempre Ativa de alta luminosidade, recurso inédito de gesto de toque duplo, recursos avançados de saúde com sensor de oxigênio no sangue e notificações de ritmo cardíaco.',
                        'price' => 3499.00,
                        'old_price' => 3999.00,
                        'stock' => 10,
                        'badges' => ['Destaque'],
                        'images' => [
                            'https://images.unsplash.com/photo-1434494878577-86c23bcb06b9?auto=format&fit=crop&q=80&w=800',
                            'https://images.unsplash.com/photo-1508685096489-7aacd43bd3b1?auto=format&fit=crop&q=80&w=800'
                        ]
                    ],
                    [
                        'name' => 'Assistente Virtual Amazon Echo Pop',
                        'slug' => 'assistente-virtual-amazon-echo-pop',
                        'description' => 'Smart speaker compacto com som direcional e Alexa completa. Controle dispositivos inteligentes por voz, pergunte sobre o clima, coloque alarmes ou reproduza suas músicas favoritas.',
                        'price' => 299.00,
                        'old_price' => 349.00,
                        'stock' => 50,
                        'badges' => ['Mais Vendido'],
                        'images' => [
                            'https://images.unsplash.com/photo-1543512214-318c7553f230?auto=format&fit=crop&q=80&w=800'
                        ]
                    ]
                ]
            ],
            [
                'name' => 'Moda & Estilo',
                'slug' => 'moda-e-estilo',
                'icon' => 'Shirt',
                'products' => [
                    [
                        'name' => 'Óculos de Sol Classic Wayfarer',
                        'slug' => 'oculos-de-sol-classic-wayfarer',
                        'description' => 'O design mais icônico da história dos óculos de sol. Armação em acetato preto de alta resistência, lentes polarizadas com proteção 100% contra raios UVA/UVB.',
                        'price' => 499.00,
                        'old_price' => 599.00,
                        'stock' => 25,
                        'badges' => ['Tendência'],
                        'images' => [
                            'https://images.unsplash.com/photo-1511499767150-a48a237f0083?auto=format&fit=crop&q=80&w=800'
                        ]
                    ],
                    [
                        'name' => 'Mochila Antifurto Impermeável Premium',
                        'slug' => 'mochila-antifurto-impermeavel-premium',
                        'description' => 'Ideal para trabalho, viagem ou estudo. Compartimento para notebook de até 15.6", saída USB externa para powerbank, zíperes ocultos, material resistente a rasgos e cortes e impermeabilidade total.',
                        'price' => 289.90,
                        'old_price' => 349.90,
                        'stock' => 40,
                        'badges' => ['Frete Grátis'],
                        'images' => [
                            'https://images.unsplash.com/photo-1553062407-98eeb64c6a62?auto=format&fit=crop&q=80&w=800'
                        ]
                    ]
                ]
            ]
        ];

        foreach ($categoriesData as $catData) {
            $category = \App\Models\Category::create([
                'company_id' => $company->id,
                'name' => $catData['name'],
                'slug' => $catData['slug'],
                'icon' => $catData['icon']
            ]);

            foreach ($catData['products'] as $prodData) {
                $product = \App\Models\Product::create([
                    'company_id' => $company->id,
                    'category_id' => $category->id,
                    'name' => $prodData['name'],
                    'slug' => $prodData['slug'],
                    'description' => $prodData['description'],
                    'price' => $prodData['price'],
                    'old_price' => $prodData['old_price'],
                    'stock' => $prodData['stock'],
                    'badges' => $prodData['badges'],
                    'available' => true,
                ]);

                foreach ($prodData['images'] as $index => $imageUrl) {
                    \App\Models\ProductImage::create([
                        'product_id' => $product->id,
                        'path' => $imageUrl,
                        'order' => $index
                    ]);
                }
            }
        }
    }
}
