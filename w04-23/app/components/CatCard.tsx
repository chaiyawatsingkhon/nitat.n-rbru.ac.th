// components/CatCard.tsx
import React from "react";

export interface Cat {
  id: number;
  name: string;
  description: string;
  imageUrl: string;
}

type CatCardProps = {
  cat: Cat;
};

const CatCard: React.FC<CatCardProps> = ({ cat }) => {
  return (
    <div
      style={{
        border: "1px solid #ddd",
        borderRadius: "8px",
        padding: "16px",
        marginBottom: "16px",
        display: "flex",
        gap: "16px",
      }}
    >
      <img
        src={cat.imageUrl}
        alt={cat.name}
        style={{
          width: "200px",
          height: "140px",
          objectFit: "cover",
          borderRadius: "8px",
        }}
      />
      <div>
        <h2 style={{ margin: "0 0 8px", fontSize: "1.25rem" }}>
          {cat.name}
        </h2>
        <p style={{ margin: 0 }}>{cat.description}</p>
      </div>
    </div>
  );
};

export default CatCard;