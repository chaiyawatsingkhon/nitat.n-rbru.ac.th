import 'package:flutter/material.dart';

void main() {
  runApp(const MyApp());
}

class MyApp extends StatelessWidget {
  const MyApp({super.key});

  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      debugShowCheckedModeBanner: false,
      title: 'w06 Form Demo',
      theme: ThemeData(
        primarySwatch: Colors.deepPurple,
        useMaterial3: true,
      ),
      home: const BoardGameFormScreen(),
    );
  }
}

class BoardGameFormScreen extends StatefulWidget {
  const BoardGameFormScreen({super.key});

  @override
  State<BoardGameFormScreen> createState() => _BoardGameFormScreenState();
}

class _BoardGameFormScreenState extends State<BoardGameFormScreen> {
  // Key สำหรับระบุและควบคุมสถานะของ Form
  final _formKey = GlobalKey<FormState>();

  // 1. Controller สำหรับ TextFormField
  final TextEditingController _nameController = TextEditingController();

  // 2. State สำหรับ DropdownButtonFormField
  String? _selectedCategory = 'Strategy';
  final List<String> _categories = ['Strategy', 'Family', 'Party', 'Card Game'];

  // 3. State สำหรับ RadioListTile (ระดับความซับซ้อน)
  String _complexity = 'Medium';

  // 4. State สำหรับ CheckboxListTile (อุปกรณ์ที่มี)
  bool _hasDice = false;
  bool _hasCards = false;

  // 5. State สำหรับ SwitchListTile (สถานะความพร้อม)
  bool _isAvailable = true;

  @override
  void dispose() {
    _nameController.dispose();
    super.dispose();
  }

  void _submitForm() {
    // ตรวจสอบความถูกต้องของฟอร์มผ่าน validator
    if (_formKey.currentState!.validate()) {
      ScaffoldMessenger.of(context).showSnackBar(
        SnackBar(
          content: Text('บันทึกข้อมูล "${_nameController.text}" เรียบร้อยแล้ว!'),
          backgroundColor: Colors.green,
        ),
      );
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: const Text('w06: Board Game Form'),
        centerTitle: true,
      ),
      body: SingleChildScrollView(
        padding: const EdgeInsets.all(16.0),
        child: Form(
          key: _formKey,
          child: Column(
            crossAxisAlignment: CrossAxisAlignment.start,
            children: [
              // ----------------------------------------------------------------
              // 1. TextFormField
              // ----------------------------------------------------------------
              const Text('1. ชื่อบอร์ดเกม', style: TextStyle(fontWeight: FontWeight.bold, fontSize: 16)),
              const SizedBox(height: 8),
              TextFormField(
                controller: _nameController,
                decoration: const InputDecoration(
                  labelText: 'กรอกชื่อบอร์ดเกม',
                  hintText: 'เช่น Catan, Splendor',
                  border: OutlineInputBorder(),
                  prefixIcon: Icon(Icons.casino),
                ),
                validator: (value) {
                  if (value == null || value.trim().isEmpty) {
                    return 'กรุณากรอกชื่อบอร์ดเกมก่อนบันทึก';
                  }
                  return null;
                },
              ),
              const SizedBox(height: 20),

              // ----------------------------------------------------------------
              // 2. DropdownButtonFormField
              // ----------------------------------------------------------------
              const Text('2. หมวดหมู่หลัก', style: TextStyle(fontWeight: FontWeight.bold, fontSize: 16)),
              const SizedBox(height: 8),
              DropdownButtonFormField<String>(
                value: _selectedCategory,
                decoration: const InputDecoration(
                  border: OutlineInputBorder(),
                  prefixIcon: Icon(Icons.category),
                ),
                items: _categories.map((String category) {
                  return DropdownMenuItem<String>(
                    value: category,
                    child: Text(category),
                  );
                }).toList(),
                onChanged: (newValue) {
                  setState(() {
                    _selectedCategory = newValue;
                  });
                },
              ),
              const SizedBox(height: 20),

              // ----------------------------------------------------------------
              // 3. RadioListTile
              // ----------------------------------------------------------------
              const Text('3. ระดับความยาก (Complexity)', style: TextStyle(fontWeight: FontWeight.bold, fontSize: 16)),
              RadioListTile<String>(
                title: const Text('Easy (เล่นง่าย)'),
                value: 'Easy',
                groupValue: _complexity,
                onChanged: (value) => setState(() => _complexity = value!),
              ),
              RadioListTile<String>(
                title: const Text('Medium (ปานกลาง)'),
                value: 'Medium',
                groupValue: _complexity,
                onChanged: (value) => setState(() => _complexity = value!),
              ),
              RadioListTile<String>(
                title: const Text('Hard (ซับซ้อน)'),
                value: 'Hard',
                groupValue: _complexity,
                onChanged: (value) => setState(() => _complexity = value!),
              ),
              const SizedBox(height: 10),

              // ----------------------------------------------------------------
              // 4. CheckboxListTile
              // ----------------------------------------------------------------
              const Text('4. อุปกรณ์ในกล่อง', style: TextStyle(fontWeight: FontWeight.bold, fontSize: 16)),
              CheckboxListTile(
                title: const Text('มีลูกเต๋า (Dice)'),
                value: _hasDice,
                onChanged: (value) => setState(() => _hasDice = value!),
              ),
              CheckboxListTile(
                title: const Text('มีการ์ดเกม (Cards)'),
                value: _hasCards,
                onChanged: (value) => setState(() => _hasCards = value!),
              ),
              const SizedBox(height: 10),

              // ----------------------------------------------------------------
              // 5. SwitchListTile
              // ----------------------------------------------------------------
              const Text('5. สถานะความพร้อม', style: TextStyle(fontWeight: FontWeight.bold, fontSize: 16)),
              SwitchListTile(
                title: const Text('พร้อมสำหรับเปิดเล่น'),
                subtitle: const Text('อุปกรณ์ครบถ้วน ไม่มีชิ้นส่วนสูญหาย'),
                value: _isAvailable,
                onChanged: (value) => setState(() => _isAvailable = value),
              ),
              const SizedBox(height: 25),

              // ปุ่มกด Submit
              SizedBox(
                width: double.infinity,
                child: ElevatedButton(
                  style: ElevatedButton.styleFrom(
                    padding: const EdgeInsets.symmetric(vertical: 16),
                  ),
                  onPressed: _submitForm,
                  child: const Text('บันทึกข้อมูลฟอร์ม', style: TextStyle(fontSize: 18)),
                ),
              ),
            ],
          ),
        ),
      ),
    );
  }
}