<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Event;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class CreateAdminUserSeeder extends Seeder
{
    public function run(): void
    {
            // بعدين نولّد 10 حدث بالقيمة 1
        Event::factory()->count(10)->create([
            'is_featured' => 1,
        ]);
        
        // إنشاء أو تحديث المستخدم المسؤول
        $adminUser = User::updateOrCreate(
            ['email' => 'omar@gmail.com'],
            [
                'name' => 'Omar Mohamed',
                'password' => Hash::make('11111111'),
                'email_verified_at' => now(),
                'status' => 'مفعل',
                'role' => 'admin',
                'is_admin' => true,
            ]
        );

        // إنشاء أو استرجاع دور المالك (owner)
        $ownerRole = Role::firstOrCreate([
            'name' => 'owner',
            'guard_name' => 'web'
        ]);

        // إنشاء أو استرجاع دور المستخدم العادي (user)
        $userRole = Role::firstOrCreate([
            'name' => 'user',
            'guard_name' => 'web'
        ]);

        // تعيين جميع الصلاحيات لدور المالك
        $permissions = Permission::pluck('id')->all();
        $ownerRole->syncPermissions($permissions);

        // تعيين الدور للمستخدم المسؤول
        $adminUser->assignRole($ownerRole);

        // إنشاء مستخدم تاني "عادي" لكن مع صلاحية المالك
        $normalUser = User::updateOrCreate(
            ['email' => 'user@gmail.com'],
            [
                'name' => 'Ahmed User',
                'password' => Hash::make('22222222'),
                'email_verified_at' => now(),
                'status' => 'مفعل',
                'role' => 'user',
                'is_admin' => false,
            ]
        );

        // تعيين أدوار المستخدم (مستخدم عادي )
        $normalUser->assignRole([$userRole]);

        // مسح كاش الصلاحيات
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // رسائل تأكيد
        $this->command->info('✅ تم إنشاء المستخدم المسؤول بنجاح!');
        $this->command->info('📧 البريد: omar@gmail.com | كلمة المرور: 11111111');

        $this->command->info('✅ تم إنشاء المستخدم العادي مع صلاحيات المالك!');
        $this->command->info('📧 البريد: user@gmail.com | كلمة المرور: 22222222');
    }
}
