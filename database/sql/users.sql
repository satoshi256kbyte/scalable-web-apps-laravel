CREATE TABLE users (
    id UUID PRIMARY KEY DEFAULT gen_random_uuid(),          -- アプリ内のユーザーID（内部管理用）
    cognito_sub UUID NOT NULL UNIQUE,                       -- Cognito のユーザー識別子（sub）
    email VARCHAR(255) NOT NULL UNIQUE,                     -- メールアドレス
    username VARCHAR(100) NOT NULL,                         -- ユーザー名
    first_name VARCHAR(100),                                -- 名（オプション）
    last_name VARCHAR(100),                                 -- 姓（オプション）
    phone_number VARCHAR(20) UNIQUE,                        -- 電話番号（オプション）
    status VARCHAR(50) DEFAULT 'ACTIVE',                    -- ユーザーステータス（ACTIVE, DISABLEDなど）
    created_at TIMESTAMPTZ DEFAULT now(),                   -- 作成日時
    updated_at TIMESTAMPTZ DEFAULT now()                    -- 更新日時
);
