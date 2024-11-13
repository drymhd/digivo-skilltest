
// Ensure you have the MongoDB Node.js driver installed
// Run: npm install mongodb

const { MongoClient, ObjectId } = require('mongodb');


async function checkoutProduct(userId, productId, quantity) {
  const uri = 'mongodb://localhost:27017';
  const client = new MongoClient(uri);

  try {
    await client.connect();
    const db = client.db('ecommerce');
    const productCollection = db.collection('products');
    const orderCollection = db.collection('orders');
    const cartCollection = db.collection('shopping_carts');

    const session = client.startSession();

    await session.withTransaction(async () => {
      // Transaction operations (reduce stock, create order, delete from cart)
      const product = await productCollection.findOne({ _id:  productId }, { session });

      
        if (!product || product.stock < quantity) throw new Error('Insufficient stock');
     
      
      const updateStockResult = await productCollection.updateOne(
        { _id: productId },
        { $inc: { stock: -quantity } },
        { session }
      );
      if (updateStockResult.modifiedCount !== 1) throw new Error('Failed to update product stock');
      
      const newOrder = {
        user_id: userId,
        product_id: productId,
        quantity,
        order_date: new Date()
      };
      const insertOrderResult = await orderCollection.insertOne(newOrder, { session });
      if (!insertOrderResult.acknowledged) throw new Error('Failed to create order');
      
      const cart = await cartCollection.findOne(
        { user_idd: userId, "product.product_id": productId },
        { session }
      );

      if (cart) {
        const deleteCartItemResult = await cartCollection.deleteOne(
          { user_id: userId, "product.product_id": productId },
          { session }
        );
        if (deleteCartItemResult.deletedCount !== 1) throw new Error('Failed to remove item from shopping cart');
      }

      console.log('Transaction successfully committed');
    });
  } catch (error) {
    console.error('Transaction aborted due to an error:', error);
  } finally {
    await client.close();
  }
}

// Usage Example
const userId = new ObjectId('6733550043b561f312db0a6b');
const productId = new ObjectId('6489b234a7d2f61234c1ac34');
const quantity = 2;

checkoutProduct(userId, productId, quantity);
