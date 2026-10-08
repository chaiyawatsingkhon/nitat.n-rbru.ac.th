import 'dart:convert'; 
import 'package:flutter/material.dart';
import 'package:http/http.dart' as http;

// 1. โมเดลข้อมูลสินค้า (Product Model)
class Product {
  final int id;
  final String title;
  final String description;
  final double price;
  final String thumbnail;

  const Product({
    required this.id,
    required this.title,
    required this.description,
    required this.price,
    required this.thumbnail,
  });

  factory Product.fromJson(Map<String, dynamic> json) {
    return Product(
      id: json['id'],
      title: json['title'],
      description: json['description'],
      price: (json['price'] as num).toDouble(),
      thumbnail: json['thumbnail'],
    );
  }
}

// 2. ฟังก์ชันดึงข้อมูลจาก API
Future<List<Product>> fetchProducts() async {
  final response = await http.get(
    Uri.parse('https://dummyjson.com/products'),
  );

  if (response.statusCode == 200) {
    final Map<String, dynamic> data = jsonDecode(response.body);
    final List<dynamic> productsJson = data['products'];
    return productsJson.map((json) => Product.fromJson(json)).toList();
  } else {
    throw Exception('Failed to load products');
  }
}

void main() => runApp(const MyApp());

class MyApp extends StatelessWidget {
  const MyApp({super.key});

  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      debugShowCheckedModeBanner: false,
      title: 'DummyJSON API Demo',
      theme: ThemeData(
        colorScheme: ColorScheme.fromSeed(seedColor: Colors.deepPurple),
        useMaterial3: true,
      ),
      home: const ProductListScreen(),
    );
  }
}

class ProductListScreen extends StatefulWidget {
  const ProductListScreen({super.key});

  @override
  State<ProductListScreen> createState() => _ProductListScreenState();
}

class _ProductListScreenState extends State<ProductListScreen> {
  late Future<List<Product>> futureProducts;

  @override
  void initState() {
    super.initState();
    futureProducts = fetchProducts();
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: const Text('DummyJSON Products API'),
        backgroundColor: Theme.of(context).colorScheme.inversePrimary,
      ),
      body: Center(
        child: FutureBuilder<List<Product>>(
          future: futureProducts,
          builder: (context, snapshot) {
            if (snapshot.hasData) {
              final products = snapshot.data!;
              return ListView.builder(
                itemCount: products.length,
                itemBuilder: (context, index) {
                  final product = products[index];
                  return Card(
                    margin: const EdgeInsets.symmetric(
                      horizontal: 12,
                      vertical: 6,
                    ),
                    child: ListTile(
                      leading: Image.network(
                        product.thumbnail,
                        width: 50,
                        height: 50,
                        fit: BoxFit.cover,
                        errorBuilder: (context, error, stackTrace) =>
                            const Icon(Icons.shopping_bag),
                      ),
                      title: Text(
                        product.title,
                        style: const TextStyle(fontWeight: FontWeight.bold),
                      ),
                      subtitle: Text(
                        product.description,
                        maxLines: 2,
                        overflow: TextOverflow.ellipsis,
                      ),
                      trailing: Text(
                        '\$${product.price}',
                        style: const TextStyle(
                          color: Colors.green,
                          fontWeight: FontWeight.bold,
                          fontSize: 16,
                        ),
                      ),
                    ),
                  );
                },
              );
            } else if (snapshot.hasError) {
              return Text('Error: ${snapshot.error}');
            }

            return const CircularProgressIndicator();
          },
        ),
      ),
    );
  }
}