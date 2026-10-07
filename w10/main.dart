import 'package:flutter/material.dart';
import 'package:path/path.dart';
import 'package:sqflite/sqflite.dart';

void main() async {
  WidgetsFlutterBinding.ensureInitialized();
  runApp(const MyApp());
}

class MyApp extends StatelessWidget {
  const MyApp({super.key});

  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      debugShowCheckedModeBanner: false,
      title: 'w10 SQLite Demo',
      theme: ThemeData(
        colorScheme: ColorScheme.fromSeed(seedColor: Colors.teal),
        useMaterial3: true,
      ),
      home: const InventoryScreen(),
    );
  }
}

// ============================================================================
// 1. Data Model & Database Helper
// ============================================================================
class Item {
  final int? id;
  final String name;
  final int quantity;
  final double price;

  Item({
    this.id,
    required this.name,
    required this.quantity,
    required this.price,
  });

  Map<String, dynamic> toMap() {
    return {
      'id': id,
      'name': name,
      'quantity': quantity,
      'price': price,
    };
  }

  factory Item.fromMap(Map<String, dynamic> map) {
    return Item(
      id: map['id'],
      name: map['name'],
      quantity: map['quantity'],
      price: (map['price'] as num).toDouble(),
    );
  }
}

class DatabaseHelper {
  static DatabaseHelper? _instance;
  static Database? _database;

  DatabaseHelper._internal();

  factory DatabaseHelper() {
    _instance ??= DatabaseHelper._internal();
    return _instance!;
  }

  Future<Database> get database async {
    if (_database != null) return _database!;
    _database = await _initDatabase();
    return _database!;
  }

  Future<Database> _initDatabase() async {
    String path = join(await getDatabasesPath(), 'inventory_database.db');
    return await openDatabase(
      path,
      version: 1,
      onCreate: (db, version) {
        return db.execute(
          '''
          CREATE TABLE items(
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            name TEXT NOT NULL,
            quantity INTEGER NOT NULL,
            price REAL NOT NULL
          )
          ''',
        );
      },
    );
  }

  // --- CRUD Operations ---
  Future<int> insertItem(Item item) async {
    final db = await database;
    return await db.insert('items', item.toMap(), conflictAlgorithm: ConflictAlgorithm.replace);
  }

  Future<List<Item>> getItems() async {
    final db = await database;
    final List<Map<String, dynamic>> maps = await db.query('items', orderBy: 'id DESC');
    return List.generate(maps.length, (i) => Item.fromMap(maps[i]));
  }

  Future<int> updateItem(Item item) async {
    final db = await database;
    return await db.update('items', item.toMap(), where: 'id = ?', whereArgs: [item.id]);
  }

  Future<int> deleteItem(int id) async {
    final db = await database;
    return await db.delete('items', where: 'id = ?', whereArgs: [item.id]);
  }
}

// ============================================================================
// 2. UI Screen & Form
// ============================================================================
class InventoryScreen extends StatefulWidget {
  const InventoryScreen({super.key});

  @override
  State<InventoryScreen> createState() => _InventoryScreenState();
}

class _InventoryScreenState extends State<InventoryScreen> {
  final DatabaseHelper _dbHelper = DatabaseHelper();
  List<Item> _itemList = [];
  bool _isLoading = true;

  @override
  void initState() {
    super.initState();
    _refreshItemList();
  }

  void _refreshItemList() async {
    setState(() => _isLoading = true);
    final data = await _dbHelper.getItems();
    setState(() {
      _itemList = data;
      _isLoading = false;
    });
  }

  void _showFormDialog(Item? item) {
    final formKey = GlobalKey<FormState>();
    final nameController = TextEditingController(text: item?.name ?? '');
    final quantityController = TextEditingController(text: item != null ? item.quantity.toString() : '');
    final priceController = TextEditingController(text: item != null ? item.price.toString() : '');

    showDialog(
      context: context,
      builder: (ctx) => AlertDialog(
        title: Text(item == null ? 'เพิ่มรายการสินค้าใหม่' : 'แก้ไขข้อมูลสินค้า'),
        content: Form(
          key: formKey,
          child: SingleChildScrollView(
            child: Column(
              mainAxisSize: MainAxisSize.min,
              children: [
                TextFormField(
                  controller: nameController,
                  decoration: const InputDecoration(labelText: 'ชื่อสินค้า / พัสดุ'),
                  validator: (val) => val == null || val.trim().isEmpty ? 'กรุณากรอกชื่อสินค้า' : null,
                ),
                TextFormField(
                  controller: quantityController,
                  decoration: const InputDecoration(labelText: 'จำนวน (ชิ้น)'),
                  keyboardType: TextInputType.number,
                  validator: (val) {
                    if (val == null || val.isEmpty) return 'กรุณากรอกจำนวน';
                    if (int.tryParse(val) == null) return 'ต้องเป็นตัวเลขเท่านั้น';
                    return null;
                  },
                ),
                TextFormField(
                  controller: priceController,
                  decoration: const InputDecoration(labelText: 'ราคาต่อชิ้น (บาท)'),
                  keyboardType: const TextInputType.numberWithOptions(decimal: true),
                  validator: (val) {
                    if (val == null || val.isEmpty) return 'กรุณากรอกราคา';
                    if (double.tryParse(val) == null) return 'ต้องเป็นตัวเลขเท่านั้น';
                    return null;
                  },
                ),
              ],
            ),
          ),
        ),
        actions: [
          TextButton(
            onPressed: () => Navigator.of(ctx).pop(),
            child: const Text('ยกเลิก'),
          ),
          ElevatedButton(
            onPressed: () async {
              if (formKey.currentState!.validate()) {
                final newItem = Item(
                  id: item?.id,
                  name: nameController.text.trim(),
                  quantity: int.parse(quantityController.text.trim()),
                  price: double.parse(priceController.text.trim()),
                );

                if (item == null) {
                  await _dbHelper.insertItem(newItem);
                } else {
                  await _dbHelper.updateItem(newItem);
                }

                _refreshItemList();
                if (mounted) Navigator.of(ctx).pop();
              }
            },
            child: Text(item == null ? 'เพิ่มข้อมูล' : 'บันทึกแก้ไข'),
          ),
        ],
      ),
    );
  }

  void _deleteItem(int id) async {
    await _dbHelper.deleteItem(id);
    ScaffoldMessenger.of(context).showSnackBar(
      const SnackBar(content: Text('ลบข้อมูลเรียบร้อยแล้ว'), backgroundColor: Colors.redAccent),
    );
    _refreshItemList();
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: const Text('w10: SQLite Inventory Tracker'),
        centerTitle: true,
        actions: [
          IconButton(
            icon: const Icon(Icons.refresh),
            onPressed: _refreshItemList,
          )
        ],
      ),
      body: _isLoading
          ? const Center(child: CircularProgressIndicator())
          : _itemList.isEmpty
              ? const Center(
                  child: Text('ยังไม่มีข้อมูลสินค้าในฐานข้อมูล SQLite\nกดปุ่ม + ด้านล่างเพื่อเพิ่มข้อมูล',
                      textAlign: TextAlign.center, style: TextStyle(color: Colors.grey, fontSize: 16)),
                )
              : ListView.builder(
                  itemCount: _itemList.length,
                  itemBuilder: (context, index) {
                    final item = _itemList[index];
                    return Card(
                      margin: const EdgeInsets.symmetric(horizontal: 12, vertical: 6),
                      child: ListTile(
                        leading: CircleAvatar(
                          child: Text('${item.quantity}'),
                        ),
                        title: Text(item.name, style: const TextStyle(fontWeight: FontWeight.bold)),
                        subtitle: Text('ราคาชิ้นละ: ${item.price.toStringAsFixed(2)} บาท'),
                        trailing: Row(
                          mainAxisSize: MainAxisSize.min,
                          children: [
                            IconButton(
                              icon: const Icon(Icons.edit, color: Colors.blue),
                              onPressed: () => _showFormDialog(item),
                            ),
                            IconButton(
                              icon: const Icon(Icons.delete, color: Colors.red),
                              onPressed: () => _deleteItem(item.id!),
                            ),
                          ],
                        ),
                      ),
                    );
                  },
                ),
      floatingActionButton: FloatingActionButton.extended(
        onPressed: () => _showFormDialog(null),
        icon: const Icon(Icons.add),
        label: const Text('เพิ่มสินค้า'),
      ),
    );
  }
}